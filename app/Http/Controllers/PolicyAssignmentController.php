<?php

namespace App\Http\Controllers;

use App\Events\PolicyAssignmentSubmitted;
use App\Models\AssignmentDocument;
use App\Models\AssignmentHistory;
use App\Models\Client;
use App\Models\Insurer;
use App\Models\InsurerPolicy;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use App\Models\SystemVariable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PolicyAssignmentController extends Controller
{
    public function create(Client $client)
    {
        $insurers = Insurer::where('status', 'active')->get();
        return view('policy_assignments.create', [
            'title' => 'Create Client Policy',
            'client' => $client,
            'insurers' => $insurers,
        ]);
    }

    public function store(Request $request, Client $client)
    {
        try {

            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'insurer_id' => 'required|exists:insurers,id',
                'policy_id' => 'required|exists:policies,id',
                'cost' => 'required|numeric',
                'currency' => 'required|string|in:usd,lrd',
                'policy_details' => 'required',
                'payment_frequency' => 'required|in:monthly,quarterly,half-yearly,yearly',
                'payment_method' => 'required|in:Cash,Cheque,Bank Transfer,Credit Card,Debit Card,Deferred',
                'action' => 'required|in:save_as_draft,save_and_create,save_and_send',
                'document_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Validate each file
            ]);


            $isDiscounted = $request->has('is_discounted') ? true : false;
            $clientPolicy = new PolicyAssignment();
            $clientPolicy->client_id = $validatedData['client_id'];
            $clientPolicy->insurer_id = $validatedData['insurer_id'];
            $clientPolicy->policy_id = $validatedData['policy_id'];
            $clientPolicy->cost = $validatedData['cost'];
            $clientPolicy->currency = $validatedData['currency'];
            $clientPolicy->notes = $validatedData['policy_details'];
            $clientPolicy->is_discounted = $isDiscounted;
            $clientPolicy->discount = $request->discount ?? 0;
            if ($isDiscounted) {
                $clientPolicy->discount_type = $request->discount_type;
            }
            $clientPolicy->user_id = Auth::id();
            $clientPolicy->payment_method = $validatedData['payment_method'];
            $clientPolicy->created_by = Auth::user()->name;
            $clientPolicy->updated_by = Auth::user()->name;
            $clientPolicy->status = ($validatedData['action'] === 'save_and_send') ? 'submitted' : 'draft';

            if ($clientPolicy->save()) {

                event(new PolicyAssignmentSubmitted($clientPolicy));

                $invoice = new Invoice();
                $invoice->invoiceable_id = $clientPolicy->id;
                $invoice->invoiceable_type = PolicyAssignment::class;
                $invoice->details = $validatedData['policy_details'];
                $invoice->total_amount = $validatedData['cost'];
                $invoice->currency = $validatedData['currency'];
                $invoice->amount_paid = 0;
                $invoice->balance = $validatedData['cost'];
                $invoice->invoice_date = now();
                $invoice->due_date = null;
                $invoice->notes = $validatedData['policy_details'];
                $invoice->created_by = Auth::user()->name;
                $invoice->updated_by = Auth::user()->name;
                $invoice->save();
                $clientPolicy->invoices()->save($invoice);


                if ($request->hasFile('document_path')) {
                    foreach ($request->file('document_path') as $file) {
                        $documentName = $file->getClientOriginalName();
                        $documentPath = $file->store('assignment_documents', 'public');

                        $assignmentDocument = new AssignmentDocument();
                        $assignmentDocument->policy_assignment_id = $clientPolicy->id;
                        $assignmentDocument->document_name = $documentName;
                        $assignmentDocument->document_path = $documentPath;
                        $assignmentDocument->document_type = $file->getClientMimeType();
                        $assignmentDocument->created_by = Auth::user()->name;
                        $assignmentDocument->updated_by = Auth::user()->name;
                        $assignmentDocument->save();
                    }
                }
            }

            $assignmentHistory = new AssignmentHistory();
            $assignmentHistory->policy_assignment_id = $clientPolicy->id;
            $assignmentHistory->user_id = Auth::id();
            $assignmentHistory->status = $clientPolicy->status;
            $assignmentHistory->comment = 'Policy created';
            $assignmentHistory->created_by = Auth::user()->name;
            $assignmentHistory->updated_by = Auth::user()->name;
            $assignmentHistory->save();

            switch ($validatedData['action']) {
                case 'save_and_create':
                    return redirect()->route('client-policies.create', ['client' => $client])
                        ->with('msg', 'Policy saved successfully. Create another.')
                        ->with('flag', 'info');

                case 'save_and_send':
                    return redirect()->route('clients.details', ['id' => $client->id])
                        ->with('msg', 'Policy saved and sent successfully.')
                        ->with('flag', 'success');

                default:
                    return redirect()->route('clients.details', ['id' => $client->id])
                        ->with('msg', 'Policy saved as draft.')
                        ->with('flag', 'info');
            }
        } catch (Exception $ex) {
            Log::error('Error in store method: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit(Client $client, $id)
    {
        $policyAssignment = PolicyAssignment::find($id);
        $insurers = Insurer::all();
        $policies = Policy::all();
        return view('policy_assignments.edit', [
            'title' => 'Edit Poilcy Assignment',
            'policyAssignment' => $policyAssignment,
            'client' => $client,
            'insurers' => $insurers,
            'policies' => $policies,
        ]);
    }

    public function update(Request $request, Client $client, $id)
    {
        try {
            $validatedData = $request->validate([
                'insurer_id' => 'required|exists:insurers,id',
                'policy_id' => 'required|exists:policies,id',
                'cost' => 'required|numeric',
                'currency' => 'required|string|in:usd,lrd',
                'policy_details' => 'required',
                'payment_frequency' => 'required|in:monthly,quarterly,half-yearly,yearly',
                'payment_method' => 'required|in:Cash,Cheque,Bank Transfer,Credit Card,Debit Card,Deferred',
                'document_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ]);

            $policyAssignment = PolicyAssignment::findOrFail($id);
            $policyAssignment->insurer_id = $validatedData['insurer_id'];
            $policyAssignment->policy_id = $validatedData['policy_id'];
            $policyAssignment->cost = $validatedData['cost'];
            $policyAssignment->currency = $validatedData['currency'];
            $policyAssignment->notes = $validatedData['policy_details'];
            $policyAssignment->payment_frequency = $validatedData['payment_frequency'];
            $policyAssignment->payment_method = $validatedData['payment_method'];
            $policyAssignment->updated_by = Auth::user()->name;

            if ($policyAssignment->save()) {
                if ($request->hasFile('document_path')) {
                    foreach ($request->file('document_path') as $file) {
                        $documentName = $file->getClientOriginalName();
                        $documentPath = $file->store('assignment_documents', 'public');

                        $assignmentDocument = new AssignmentDocument();
                        $assignmentDocument->policy_assignment_id = $policyAssignment->id;
                        $assignmentDocument->document_name = $documentName;
                        $assignmentDocument->document_path = $documentPath;
                        $assignmentDocument->document_type = $file->getClientMimeType();
                        $assignmentDocument->created_by = Auth::user()->name;
                        $assignmentDocument->updated_by = Auth::user()->name;
                        $assignmentDocument->save();
                    }
                }
            }

            return redirect()->route('clients.details', ['id' => $client->id])
                ->with('msg', 'Policy updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error in update method: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details(Client $client, $id)
    {
        $policyAssignment = PolicyAssignment::with('insurer', 'policy')->findOrFail($id);
        return view('policy_assignments.details', [
            'title' => 'Policy Assignment Details',
            'policyAssignment' => $policyAssignment,
            'client' => $client
        ]);
    }


    public function destroy(Client $client, $id)
    {
        try {
            $policyAssignment = PolicyAssignment::findOrFail($id);
            $policyAssignment->delete();

            return redirect()->route('clients.details', ['id' => $client->id])
                ->with('msg', 'Policy deleted successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error in destroy method: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function setPolicyStatus(Client $client, $id, Request $request)
    {
        try {

            $policyAssignment = PolicyAssignment::find($id);
            $status = $request->input('status');

            if ($status === 'submitted') {
                $policyAssignment->status = 'submitted';
            } elseif ($status === 'approve') {


                $policyAssignment->status = 'approved';

                $client = $policyAssignment->client;
                $invoice = Invoice::where('invoiceable_id', $policyAssignment->id)
                    ->where('invoiceable_type', PolicyAssignment::class)
                    ->first();

                $dueDate = match ($policyAssignment->policy->premium_frequency) {
                    'monthly' => now()->addMonth(),
                    'quarterly' => now()->addMonths(3),
                    'half-yearly' => now()->addMonths(6),
                    'yearly' => now()->addYear(),
                    default => now(),
                };

                $invoice->due_date = $dueDate;
                $invoice->save();

                $policyAssignment->policy_duration_start = now();
                $policyAssignment->policy_duration_end = $dueDate;
                $systemName = SystemVariable::where('type', 'name')->first();
                $systemEmail = SystemVariable::where('type', 'email')->first();
                $systemAddress = SystemVariable::where('type', 'address')->first();
                $systemPhone = SystemVariable::where('type', 'phone')->first();

                $pdf = Pdf::loadView('invoices.pdf', [
                    'invoice' => $invoice,
                    'systemName' => $systemName->value,
                    'systemAddress' => $systemAddress->value,
                    'systemEmail' => $systemEmail->value,
                    'systemPhone' => $systemPhone->value,
                ]);

                Mail::send('emails.policy_approved', compact('client', 'policyAssignment'), function ($message) use ($client, $pdf, $invoice) {
                    $message->to($client->email)
                        ->subject('Policy Approved')
                        ->attachData($pdf->output(), 'invoice_' . $invoice->invoice_id . '.pdf');
                });
            } elseif ($status === 'reject') {
                $policyAssignment->status = 'rejected';
            } elseif ($status === 'completed') {
                $policyAssignment->status = 'completed';
            }
            $policyAssignment->save();

            return redirect()->route('clients.details', ['id' => $client->id])
                ->with('msg', 'Policy status updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            return back()->with('msg', 'Error:' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function uploadDocuments(Client $client, $id, Request $request)
    {
        $policyAssignment = PolicyAssignment::find($id);
        $documents = [];
        if ($request->hasFile('document_path')) {
            foreach ($request->file('document_path') as $file) {
                $documents[] = [
                    'policy_assignment_id' => $policyAssignment->id,
                    'document_name' => $file->getClientOriginalName(),
                    'document_path' => $file->store('assignment_documents', 'public'),
                    'document_type' => $file->getClientMimeType(),
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            AssignmentDocument::insert($documents);
        }
        return redirect()->route('clients.details', ['id' => $client->id])
            ->with('msg', 'Documents uploaded successfully.')
            ->with('flag', 'success');
    }
}
