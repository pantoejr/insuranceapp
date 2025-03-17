<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Insurer;
use App\Models\InsurerPolicy;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'insurer_id' => 'required|exists:insurers,id',
            'policy_id' => 'required|exists:policies,id',
            'cost' => 'nullable|numeric',
            'currency' => 'required|string|in:usd,lrd',
            'policy_duration_start' => 'required|date',
            'policy_duration_end' => 'required|date|after:policy_duration_start',
            'payment_method' => 'required|in:Cash,Cheque,Bank Transfer,Credit Card,Debit Card,Deferred',
            'action' => 'required|in:save_as_draft,save_and_create,save_and_send',
        ]);

        // Save the client policy
        $clientPolicy = new PolicyAssignment();
        $clientPolicy->client_id = $validatedData['client_id'];
        $clientPolicy->insurer_id = $validatedData['insurer_id'];
        $clientPolicy->policy_id = $validatedData['policy_id'];
        $clientPolicy->cost = $validatedData['cost'];
        $clientPolicy->policy_duration_start = $validatedData['policy_duration_start'];
        $clientPolicy->policy_duration_end = $validatedData['policy_duration_end'];
        $clientPolicy->payment_method = $validatedData['payment_method'];
        $clientPolicy->status = ($validatedData['action'] === 'save_as_draft') ? 'draft' : 'active';
        $clientPolicy->save();

        // Handle the action
        switch ($validatedData['action']) {
            case 'save_and_create':
                return redirect()->route('client-policies.create', ['client' => $client])
                    ->with('success', 'Policy saved successfully. Create another.');

            case 'save_and_send':
                // Implement logic to send the policy (e.g., send an email)
                return redirect()->route('clients.details', ['id' => $client->id])
                    ->with('success', 'Policy saved and sent successfully.');

            default: // save_as_draft
                return redirect()->route('clients.details', ['id' => $client->id])
                    ->with('success', 'Policy saved as draft.');
        }
    }
}
