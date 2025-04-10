<?php

namespace App\Http\Controllers;

use App\Events\PolicyAssignmentSubmitted;
use App\Models\AssignmentDocument;
use App\Models\AssignmentHistory;
use App\Models\Client;
use App\Models\Insurer;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use App\Models\SystemVariable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssignPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $assignPolicies = PolicyAssignment::all();
        return view('assign_policy.index', [
            'title' => 'Client Policy',
            'assignPolicies' => $assignPolicies,
        ]);
    }

    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        $insurers = Insurer::where('status', 'active')->get();
        return view('assign_policy.create', [
            'title' => 'Create Client Policy',
            'insurers' => $insurers,
            'clients' => $clients,
        ]);
    }

    public function getInsurerPolicies($insurer_id)
    {
        $policies = Policy::join('insurer_policies', 'policies.id', '=', 'insurer_policies.policy_id')
            ->join('policy_types', 'policies.policy_type_id', '=', 'policy_types.id')
            ->where('insurer_policies.insurer_id', $insurer_id)
            ->where('insurer_policies.status', 'active')
            ->select('policies.id', 'policy_types.name as policy_type')
            ->get();

        return response()->json($policies);
    }

    public function getPolicyDetails($policy_id): \Illuminate\Http\JsonResponse
    {
        $policy = Policy::find($policy_id);
        return response()->json($policy);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request data
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
                'document_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Corrected validation rule
                'terms_conditions' => 'nullable|string',
            ]);

            // Create the PolicyAssignment record
            $clientPolicy = PolicyAssignment::create([
                'client_id' => $validatedData['client_id'],
                'insurer_id' => $validatedData['insurer_id'],
                'policy_id' => $validatedData['policy_id'],
                'cost' => $validatedData['cost'],
                'currency' => $validatedData['currency'],
                'is_discounted' => $request->has('is_discounted'),
                'discount' => $request->discount ?? 0,
                'discount_type' => $request->has('is_discounted') ? $request->discount_type : null,
                'user_id' => Auth::id(),
                'payment_method' => $validatedData['payment_method'],
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
                'status' => ($validatedData['action'] === 'save_and_send') ? 'submitted' : 'draft',
            ]);

            // Fire the PolicyAssignmentSubmitted event
            event(new PolicyAssignmentSubmitted($clientPolicy));

            // Create the Invoice record
            $invoice = Invoice::create([
                'invoiceable_id' => $clientPolicy->id,
                'invoiceable_type' => PolicyAssignment::class,
                'details' => $validatedData['policy_details'],
                'total_amount' => $validatedData['cost'],
                'currency' => $validatedData['currency'],
                'amount_paid' => 0,
                'balance' => $validatedData['cost'],
                'invoice_date' => now(),
                'due_date' => null,
                'notes' => $validatedData['terms_conditions'],
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            // Attach the invoice to the policy assignment
            $clientPolicy->invoices()->save($invoice);

            // Handle file uploads
            if ($request->hasFile('document_path')) { // Corrected file access
                $documents = [];
                foreach ($request->file('document_path') as $file) { // Corrected file access
                    $documents[] = [
                        'policy_assignment_id' => $clientPolicy->id,
                        'document_name' => $file->getClientOriginalName(),
                        'document_path' => $file->store('assignment_documents', 'public'),
                        'document_type' => $file->getClientMimeType(),
                        'created_by' => Auth::user()->name,
                        'updated_by' => Auth::user()->name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                AssignmentDocument::insert($documents); // Bulk insert
            }

            // Create assignment history
            AssignmentHistory::create([
                'policy_assignment_id' => $clientPolicy->id,
                'user_id' => Auth::id(),
                'status' => $clientPolicy->status,
                'comment' => 'Policy created',
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            DB::commit();

            // Redirect based on the action
            return match ($validatedData['action']) {
                'save_and_create' => redirect()->route('assign-policy.create')
                    ->with('msg', 'Policy saved successfully. Create another.')
                    ->with('flag', 'primary'),
                'save_and_send' => redirect()->route('assign-policy.index')
                    ->with('msg', 'Policy saved and sent successfully.')
                    ->with('flag', 'success'),
                default => redirect()->route('assign-policy.index')
                    ->with('msg', 'Policy saved as draft.')
                    ->with('flag', 'info'),
            };
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Error in store method: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $assignPolicy = PolicyAssignment::find($id);
        $clients = Client::where('status', 'active')->get();
        $insurers = Insurer::where('status', 'active')->get();
        return view('assign_policy.edit', [
            'title' => 'Edit Client Policy',
            'assignPolicy' => $assignPolicy,
            'insurers' => $insurers,
            'clients' => $clients,
        ]);
    }


    public function details($id)
    {
        $policyAssignment = PolicyAssignment::find($id);
        $clients = Client::where('status', 'active')->get();
        $insurers = Insurer::where('status', 'active')->get();
        return view('assign_policy.details', [
            'title' => 'Client Policy Details',
            'policyAssignment' => $policyAssignment,
            'insurers' => $insurers,
            'clients' => $clients,
        ]);
    }

    public function setPolicyStatus($id, Request $request)
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

            return redirect()->route('assign-policy.details', $id)
                ->with('msg', 'Policy status updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            return back()->with('msg', 'Error:' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function uploadDocuments($id, Request $request)
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
        return redirect()->route('assign-policy.details', $id)
            ->with('msg', 'Documents uploaded successfully.')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $policyAssignment = PolicyAssignment::find($id);
        $policyAssignment->delete();
        return redirect()->route('assign-policy.index')->with('msg', 'Policy deleted successfully.')
            ->with('flag', 'success');
    }
}
