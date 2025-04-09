<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Claim;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create(Client $client)
    {
        $policies = Policy::join('policy_assignments', 'policies.id', '=', 'policy_assignments.policy_id')
            ->join('policy_types', 'policies.policy_type_id', '=', 'policy_types.id')
            ->where('policy_assignments.client_id', $client->id)
            ->select('policies.id', 'policies.*')
            ->get();
        return view('claims.create', [
            'title' => 'Create Claim',
            'client' => $client,
            'policies' => $policies,
        ]);
    }

    public function store(Client $client, Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'policy_id' => 'required|exists:policies,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string|in:usd,lrd',
            'claim_type' => 'required|string',
            'description' => 'required|string',
            'claim_document.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $validatedData['created_by'] = Auth::user()->name;
        $validatedData['updated_by'] = Auth::user()->name;
        $validatedData['status'] = 'Pending Review';

        $claim = Claim::create([
            'client_id' => $validatedData['client_id'],
            'policy_id' => $validatedData['policy_id'],
            'amount' => $validatedData['amount'],
            'currency' => $validatedData['currency'],
            'claim_type' => $validatedData['claim_type'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'created_by' => $validatedData['created_by'],
            'updated_by' => $validatedData['updated_by'],
        ]);

        if ($request->hasFile('claim_document')) {
            foreach ($request->file('claim_document') as $file) {
                $filePath = $file->store('attachments', 'public');
                $fileType = mime_content_type($file->getPathname());

                $attachment = new Attachment([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);

                $claim->attachments()->save($attachment);
            }
        }

        return redirect()->route('clients.details', ['id' => $client])
            ->with('msg', 'Claim submitted successfully')
            ->with('flag', 'success');
    }

    public function details(Client $client, $id)
    {
        $claim = Claim::with('policy')->where('id', $id)->first();
        $policies = Policy::all();
        return view('claims.details', [
            'title' => 'Claim Details',
            'claim' => $claim,
            'client' => $client,
            'policies' => $policies,
        ]);
    }

    public function edit(Client $client, $id)
    {
        $policies = Policy::all();
        $claim = Claim::with('policy')->where('id', $id)->first();
        return view('claims.edit', [
            'title' => 'Edit Claim',
            'claim' => $claim,
            'client' => $client,
            'policies' => $policies
        ]);
    }


    public function update(Client $client, Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'policy_id' => 'required|exists:policies,id',
                'amount' => 'required|numeric|min:0',
                'currency' => 'required|in:usd,lrd',
                'claim_type' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            $validatedData['status'] = "Pending Review";
            $validatedData['updated_by'] = Auth::user()->name;

            $claim = Claim::findOrFail($id);
            $claim->client_id = $validatedData['client_id'];
            $claim->policy_id = $validatedData['policy_id'];
            $claim->amount = $validatedData['amount'];
            $claim->currency = $validatedData['currency'];
            $claim->claim_type = $validatedData['claim_type'];
            $claim->description = $validatedData['description'];
            $claim->updated_by = $validatedData['updated_by'];
            $claim->status = $validatedData['status'];
            $claim->save();

            return redirect()->route('clients.details', ['id' => $client])
                ->with('msg', 'Claim updated successfully')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return back()->with('msg', 'Error: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function setStatus(Client $client, Request $request, $id)
    {
        try {
            $claim = Claim::find($id);
            $status = $request->input('status');

            if ($status === 'Approved') {
                $claim->status = 'Approved';
                $client = $claim->client;

                $invoice = Invoice::create([
                    'invoiceable_id' => $claim->id,
                    'invoiceable_type' => Claim::class,
                    'details' => $claim->description,
                    'total_amount' => $claim->amount,
                    'currency' => $claim->currency,
                    'amount_paid' => 0,
                    'balance' => $claim->amount,
                    'invoice_date' => now(),
                    'due_date' => null,
                    'notes' => $claim->claim_type,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);
                $claim->invoices()->save($invoice);
            } elseif ($status === 'Processed') {

                $invoice = Invoice::where('invoiceable_id', $claim->id)
                    ->where('invoiceable_type', Claim::class)
                    ->first();

                $invoice->due_date = now();
                $invoice->save();

                $claim->status = 'Processed';
            } elseif ($status === 'reject') {
                $claim->status = 'rejected';
            }
            $claim->save();

            return redirect()->route('clients.details', ['id' => $client->id])
                ->with('msg', 'Claim updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            return back()->with('msg', 'Error:' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy(Client $client, $id)
    {
        $claim = Claim::findOrFail($id);
        $claim->delete();
        return redirect()->route('clients.details', ['id' => $client])
            ->with('msg', 'Claim deleted successfully')
            ->with('flag', 'success');
    }
}
