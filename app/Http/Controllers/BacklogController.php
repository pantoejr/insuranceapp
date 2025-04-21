<?php

namespace App\Http\Controllers;

use App\Models\AssignmentDocument;
use App\Models\AssignmentHistory;
use App\Models\Client;
use App\Models\Insurer;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use App\Models\PolicySubType;
use App\Models\PolicyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BacklogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function policyAssignments()
    {
        $policyAssignments = PolicyAssignment::all();
        return view('backlog.policy_assignments', [
            'title' => 'Backlog Policy Assignments',
            'policyAssignments' => $policyAssignments
        ]);
    }

    public function createPolicyAssignment()
    {
        $clients = Client::all();
        $insurers = Insurer::all();
        return view('backlog.create_policy_assignment', [
            'title' => 'Create Backlog Policy',
            'clients' => $clients,
            'insurers' => $insurers
        ]);
    }

    public function storePolicyAssignment(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'policy_type_id' => 'required',
                'policy_sub_type_id' => 'nullable',
                'client_id' => 'exists:clients,id',
                'policy_id' => 'required|exists:policies,id',
                'insurer_id' => 'required|exists:insurers,id',
                'cost' => 'required|numeric',
                'currency' => 'required|in:usd,lrd',
                'is_discounted' => 'nullable',
                'discount_type' => 'nullable|in:fixed,percentage',
                'discount' => 'nullable|numeric',
                'policy_duration_start' => 'required|date',
                'policy_duration_end' => 'required|date|after:policy_duration_start',
                'vehicle_make' => 'nullable|string',
                'vehicle_year' => 'nullable|string',
                'vehicle_VIN' => 'nullable|string',
                'vehicle_reg_number' => 'nullable|string',
                'vehicle_use_type' => 'nullable',
                'payment_method' => 'required',
                'policy_details' => 'required',
                'action' => 'required|in:save_as_draft,save_and_create,save_and_send',
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
            $clientPolicy->policy_duration_start = $validatedData['policy_duration_start'];
            $clientPolicy->policy_duration_end = $validatedData['policy_duration_end'];

            if ($isDiscounted) {
                $clientPolicy->discount_type = $request->discount_type;
            }
            $clientPolicy->user_id = Auth::id();
            $clientPolicy->payment_method = $validatedData['payment_method'];
            $clientPolicy->created_by = Auth::user()->name;
            $clientPolicy->updated_by = Auth::user()->name;
            $clientPolicy->status = 'completed';

            // Save vehicle details if policy type is "Motor Insurance"
            if ($request->input('policy_type_name') === 'Auto Insurance' || $request->input('policy_type_name') === 'Motor Insurance') {
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
                'save_and_create' => redirect()->route('backlog.addPolicyAssignment')
                    ->with('msg', 'Policy saved successfully. Create another.')
                    ->with('flag', 'primary'),
                'save_and_send' => redirect()->route('backlog.policyAssignments')
                    ->with('msg', 'Policy saved and sent successfully.')
                    ->with('flag', 'success'),
                default => redirect()->route('backlog.policyAssignments')
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

    public function editPolicyAssignment($id)
    {
        $policyAssignment = PolicyAssignment::findOrFail($id);
        return view('backlog.edit_policy_assignment', [
            'title' => 'Edit Backlog Policy',
            'policyAssignment' => $policyAssignment,
            'clients' => Client::all(),
            'insurers' => Insurer::all(),
            'policies' => Policy::all(),
            'policyTypes' => PolicyType::all(),
            'policySubTypes' => PolicySubType::all(),
        ]);
    }


    public function updatePolicyAssignment(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $validatedData = $request->validate([
                'policy_type_id' => 'required|exists:policy_types,id',
                'policy_sub_type_id' => 'nullable|exists:policy_sub_types,id',
                'client_id' => 'required|exists:clients,id',
                'policy_id' => 'required|exists:policies,id',
                'insurer_id' => 'required|exists:insurers,id',
                'cost' => 'required|numeric|min:0',
                'currency' => 'required|in:usd,lrd',
                'is_discounted' => 'nullable|boolean',
                'discount_type' => 'nullable|in:percentage,fixed',
                'discount' => 'nullable|numeric|min:0',
                'policy_duration_start' => 'required|date',
                'policy_duration_end' => 'required|date|after_or_equal:policy_duration_start',
                'vehicle_make' => 'nullable|string|max:255',
                'vehicle_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'vehicle_VIN' => 'nullable|string|max:255',
                'vehicle_reg_number' => 'nullable|string|max:255',
                'vehicle_use_type' => 'nullable|in:personal,commercial,corporate',
                'payment_method' => 'required|string|max:255',
                'document_path.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            ]);

            $policyAssignment = PolicyAssignment::findOrFail($id);

            // Update the policy assignment with validated data
            $policyAssignment->update($validatedData);

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

            // Redirect back with success message
            return redirect()->route('backlog.policyAssignments')
                ->with('msg', 'Policy Assignment updated successfully.')
                ->with('flag','success');
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }
    public function deletePolicyAssignment($id)
    {
        $policyAssignment = PolicyAssignment::findOrFail($id);
        $policyAssignment->delete();
        return to_route('backlog.policyAssignments')
            ->with('msg', 'Policy deleted successfully')
            ->with('flag', 'success');
    }

    public function policyAssignmentDetails($id){
        $policyAssignment = PolicyAssignment::with(['client', 'insurer', 'policy', 'policyType', 'policySubType'])
            ->where('id', $id)
            ->first();

        return view('backlog.policy_assignment_details', [
            'title' => 'Policy Assignment Details',
            'policyAssignment' => $policyAssignment,
        ]);
    }
}
