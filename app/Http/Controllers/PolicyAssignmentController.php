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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
}
