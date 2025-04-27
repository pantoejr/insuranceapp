<?php

namespace App\Http\Controllers;

use App\Events\PolicyAssignmentSubmitted;
use App\Helpers\SmsHelper;
use App\Models\AssignmentDocument;
use App\Models\AssignmentHistory;
use App\Models\Client;
use App\Models\Insurer;
use App\Models\InsurerAssignment;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use App\Models\PolicySubType;
use App\Models\PolicyType;
use App\Models\SystemVariable;
use App\Models\User;
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
            ->select('policies.*', 'policy_types.name as policy_type', 'policy_types.id as policyTypeId')
            ->with(['policyType.policySubTypes'])
            ->get();

        return response()->json($policies);
    }

    public function getPolicyDetails($policy_id)
    {
        $policy = Policy::with([
            'policyType.policySubTypes',
        ])->findOrFail($policy_id);
        return response()->json($policy);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'insurer_id' => 'required|exists:insurers,id',
                'policy_id' => 'required|exists:policies,id',
                'policy_type_id' => 'nullable|exists:policy_types,id',
                'policy_type_name' => 'nullable|string',
                'policy_sub_type_id' => 'nullable|exists:policy_sub_types,id',
                'cost' => 'required|numeric',
                'currency' => 'required|string|in:usd,lrd',
                'policy_details' => 'required',
                'payment_frequency' => 'required|in:monthly,quarterly,half-yearly,yearly',
                'payment_method' => 'required|in:Cash,Cheque,Bank Transfer,Credit Card,Debit Card,Deferred',
                'action' => 'required|in:save_as_draft,save_and_create,save_and_send',
                'document_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'vehicle_make' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_year' => 'nullable|integer|required_if:policy_type,Motor Insurance',
                'vehicle_VIN' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_reg_number' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_use_type' => 'nullable|string|required_if:policy_type,Motor Insurance',
            ]);


            $isDiscounted = $request->has('is_discounted') ? true : false;
            $clientPolicy = new PolicyAssignment();
            $clientPolicy->client_id = $validatedData['client_id'];
            $clientPolicy->insurer_id = $validatedData['insurer_id'];
            $clientPolicy->policy_id = $validatedData['policy_id'];
            $clientPolicy->cost = $validatedData['cost'];
            $clientPolicy->currency = $validatedData['currency'];
            $clientPolicy->notes = $validatedData['policy_details'];
            $clientPolicy->policy_type_id = $validatedData['policy_type_id'];
            $clientPolicy->policy_sub_type_id = $validatedData['policy_sub_type_id'];
            $clientPolicy->is_discounted = $isDiscounted;
            $clientPolicy->discount = $request->discount ?? 0;


            if ($isDiscounted) {
                $clientPolicy->discount_type = $request->discount_type;
            }
            $clientPolicy->user_id = Auth::id();
            $clientPolicy->payment_method = $validatedData['payment_method'];
            $clientPolicy->created_by = Auth::user()->name;
            $clientPolicy->updated_by = Auth::user()->name;
            $clientPolicy->status = 'draft';

            // Save vehicle details if policy type is "Motor Insurance"
            if (str_contains($request->input('policy_type_name'), "Auto Insurance") || str_contains($request->input('policy_type_name'), "Motor Insurance")) {
                $clientPolicy->vehicle_make = $validatedData['vehicle_make'];
                $clientPolicy->vehicle_year = $validatedData['vehicle_year'];
                $clientPolicy->vehicle_VIN = $validatedData['vehicle_VIN'];
                $clientPolicy->vehicle_reg_number = $validatedData['vehicle_reg_number'];
                $clientPolicy->vehicle_use_type = $validatedData['vehicle_use_type'];
            }

            if ($clientPolicy->save()) {

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
                    AssignmentDocument::insert($documents);
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
        $policies = Policy::all();
        $policySubTypes = PolicySubType::all();
        return view('assign_policy.edit', [
            'title' => 'Edit Client Policy',
            'assignPolicy' => $assignPolicy,
            'insurers' => $insurers,
            'clients' => $clients,
            'policies' => $policies,
            'policySubTypes' => $policySubTypes,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'insurer_id' => 'required|exists:insurers,id',
                'policy_id' => 'required|exists:policies,id',
                'policy_type_id' => 'nullable|exists:policy_types,id',
                'policy_type_name' => 'nullable|string',
                'policy_id' => 'required|exists:policies,id',
                'cost' => 'required|numeric',
                'currency' => 'required|string|in:usd,lrd',
                'policy_details' => 'required',
                'payment_frequency' => 'required|in:monthly,quarterly,half-yearly,yearly',
                'payment_method' => 'required|in:Cash,Cheque,Bank Transfer,Credit Card,Debit Card,Deferred',
                'document_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'vehicle_make' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_year' => 'nullable|integer|required_if:policy_type,Motor Insurance',
                'vehicle_VIN' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_reg_number' => 'nullable|string|required_if:policy_type,Motor Insurance',
                'vehicle_use_type' => 'nullable|string|required_if:policy_type,Motor Insurance',
            ]);

            $policyAssignment = PolicyAssignment::findOrFail($id);
            $policyAssignment->insurer_id = $validatedData['insurer_id'];
            $policyAssignment->policy_id = $validatedData['policy_id'];
            $policyAssignment->cost = $validatedData['cost'];
            $policyAssignment->currency = $validatedData['currency'];
            $policyAssignment->notes = $validatedData['policy_details'];
            $policyAssignment->payment_frequency = $validatedData['payment_frequency'];
            $policyAssignment->payment_method = $validatedData['payment_method'];
            $policyAssignment->policy_type_id = $validatedData['policy_type_id'];
            $policyAssignment->policy_sub_type_id = $validatedData['policy_sub_type_id'];
            $policyAssignment->updated_by = Auth::user()->name;


            if ($request->input('policy_type_name') === 'Motor Insurance') {
                $policyAssignment->vehicle_make = $validatedData['vehicle_make'];
                $policyAssignment->vehicle_year = $validatedData['vehicle_year'];
                $policyAssignment->vehicle_VIN = $validatedData['vehicle_VIN'];
                $policyAssignment->vehicle_reg_number = $validatedData['vehicle_reg_number'];
                $policyAssignment->vehicle_use_type = $validatedData['vehicle_use_type'];
            }

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

            return redirect()->route('assign-policy.index')
                ->with('msg', 'Policy updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error in update method: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }


    public function details($id)
    {
        $policyAssignment = PolicyAssignment::with('insurer', 'policy', 'policyType', 'policySubType', 'client')->findOrFail($id);
        return view('assign_policy.details', [
            'title' => 'Client Policy Details',
            'policyAssignment' => $policyAssignment,
        ]);
    }

    public function setPolicyStatus($id, Request $request)
    {
        try {

            $policyAssignment = PolicyAssignment::find($id);
            $status = $request->input('status');
            if (!in_array($status, ['submitted', 'approved', 'rejected', 'completed'])) {
                return back()->with('msg', 'Invalid status')->with('flag', 'danger');
            }

            $client = Client::findOrFail($policyAssignment->client_id);

            $policyType = PolicyType::find($policyAssignment->policy_type_id);
            $insurer = Insurer::findOrFail($policyAssignment->insurer_id);

            $policyAssignment->status = $status;

            switch ($status) {
                case 'submitted':
                    $this->handleSubmittedStatus($insurer, $policyAssignment);
                    break;

                case 'approved':
                    $this->handleApprovedStatus($client, $policyAssignment, $insurer, $policyType);
                    break;

                case 'rejected':
                case 'completed':
                    $this->handleCompletedStatus($client, $policyAssignment, $insurer, $policyType);
                    break;
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

    private function handleSubmittedStatus(Insurer $insurer, PolicyAssignment $policyAssignment)
    {
        $users = User::permission('approve-policy')->get();

        foreach ($users as $user) {
            Mail::send('emails.policy_submitted', [
                'user' => $user,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('New Policy Submission Notification');
            });
        }
    }


    private function handleApprovedStatus(Client $client, PolicyAssignment $policyAssignment, Insurer $insurer, $policyType)
    {

        $insurerAssignments = InsurerAssignment::where([
            'insurer_id' => $insurer->id,
            'status' => 'active'
        ])->get();


        $directory = storage_path('app/public/policy_documents');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $isMotorPolicy = stripos($policyType->name, 'Auto') !== false
            || stripos($policyType->name, 'Auto') !== false;

        $pdfTemplate = $isMotorPolicy ? 'invoices.slip' : 'invoices.pdf';
        $attachmentName = ($isMotorPolicy ? 'motor_quotation_slip' : 'quotation_placing_slip')
            . '_' . $client->name . '.pdf';

        // Update policy duration and invoice
        if ($policyAssignment->policy->premium_frequency) {
            $invoice = Invoice::where('invoiceable_id', $policyAssignment->id)
                ->where('invoiceable_type', PolicyAssignment::class)
                ->first();

            if ($invoice) {
                $invoice->due_date = $this->calculateDueDate($policyAssignment->policy->premium_frequency);
                $invoice->save();

                $policyAssignment->policy_duration_start = now();
                $policyAssignment->policy_duration_end = $invoice->due_date;
            }
        }
        $policyAssignment->save();

        // Generate the PDF
        $timestamp = now()->format('Ymd_His');
        $fileName = $client->full_name . '_' . $timestamp . '.pdf';
        $filePath = 'policy_documents/' . $fileName;

        $pdf = Pdf::loadView($pdfTemplate, [
            'insurer' => $insurer,
            'policyAssignment' => $policyAssignment,
            'client' => $client,
            'policyType' => $policyType,
        ]);

        $pdf->save(storage_path('app/public/' . $filePath));

        Mail::send('emails.policy_approved', [
            'client' => $client,
            'policyAssignment' => $policyAssignment,
            'policyType' => $policyType,
            'insurer' => $insurer,
        ], function ($message) use ($insurer, $pdf, $attachmentName, $policyType, $insurerAssignments) {
            $message->to($insurer->email)
                ->cc(array_merge($insurerAssignments->pluck('email')->toArray(), [$insurer->key_contact_email]))
                ->bcc(['aking@safeinsurancebrokers.com', 'pantoejr@gmail.com'])
                ->subject($policyType->name . ' Request')
                ->attachData($pdf->output(), $attachmentName);
        });
    }


    private function handleCompletedStatus(Client $client, PolicyAssignment $policyAssignment, Insurer $insurer, $policyType)
    {
        $attachmentName = ('inv') . '_' . $client->full_name . '.pdf';

        $invoice = Invoice::where('invoiceable_id', $policyAssignment->id)
            ->where('invoiceable_type', PolicyAssignment::class)
            ->first();

        // Update policy duration and invoice
        if ($policyAssignment->policy->premium_frequency) {
            $invoice = Invoice::where('invoiceable_id', $policyAssignment->id)
                ->where('invoiceable_type', PolicyAssignment::class)
                ->first();

            if ($invoice) {
                $invoice->due_date = $this->calculateDueDate($policyAssignment->policy->premium_frequency);
                $invoice->save();

                $policyAssignment->policy_duration_start = now();
                $policyAssignment->policy_duration_end = $invoice->due_date;
            }
        }
        $policyAssignment->save();

        // Generate PDF with all required data including policyAssignment
        $pdf = Pdf::loadView('invoices.pdf', [
            'insurer' => $insurer,
            'invoice' => $invoice,
            'policyAssignment' => $policyAssignment,
            'client' => $client,
            'policyType' => $policyType,
        ]);

        // Send email with attachment
        SmsHelper::sendSms($client->phone, 'Dear ' . $client->full_name .  ', Your insurance policy is now complete—thank you for choosing SAFE Insurance Brokers! Kindly visit us on 2nd Street, Sinkor (adjacent Monroe Chicken) or call 0888669090 / 0775061697 to arrange document delivery.');
        Mail::send('emails.policy_completed', [
            'client' => $client,
            'policyAssignment' => $policyAssignment,
            'policyType' => $policyType,
            'insurer' => $insurer,
        ], function ($message) use ($client, $pdf, $attachmentName) {
            $message->to($client->email)
                ->subject('Policy Approved')
                ->attachData($pdf->output(), $attachmentName);
        });
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

    private function calculateDueDate($frequency)
    {
        return match ($frequency) {
            'monthly' => now()->addMonth(),
            'quarterly' => now()->addMonths(3),
            'half-yearly' => now()->addMonths(6),
            'yearly' => now()->addYear(),
            default => now(),
        };
    }
}
