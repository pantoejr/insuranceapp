<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\InsurerPolicy;
use App\Models\Policy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class InsurerPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $insurerPolicies = InsurerPolicy::all();
        return view('insurer_policies.index', [
            'title' => 'Insurer Policies',
            'insurerPolicies' => $insurerPolicies,
        ]);
    }

    public function create()
    {
        $insurers = Insurer::where('status', 'active')->get();
        $policies = Policy::where('status', 'active')->get();
        return view('insurer_policies.create', [
            'title' => 'Create Insurer Policy',
            'insurers' => $insurers,
            'policies' => $policies,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'policy_id' => 'required|exists:policies,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $insurerPolicy = InsurerPolicy::create([
                'insurer_id' => $request->insurer_id,
                'policy_id' => $request->policy_id,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurer-policies.index')->with('msg', 'Insurer Policy created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the insurer policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $insurers = Insurer::where('status', 'active')->get();
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        $policies = Policy::where('status', 'active')->get();
        return view('insurer_policies.edit', [
            'title' => 'Edit Insurer Policy',
            'insurerPolicy' => $insurerPolicy,
            'insurers' => $insurers,
            'policies' => $policies,
        ]);
    }

    public function update(Request $request, $id)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);

        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'policy_id' => 'required|exists:policies,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $insurerPolicy->update([
                'insurer_id' => $request->insurer_id,
                'policy_id' => $request->policy_id,
                'status' => $request->status,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurer-policies.index')->with('msg', 'Insurer Policy updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the insurer policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $insurerPolicy = InsurerPolicy::findOrFail($id);
            $insurerPolicy->delete();

            return redirect()->route('insurer-policies.index')->with('msg', 'Insurer Policy deleted successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the insurer policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        return view('insurer_policies.details', [
            'title' => 'Insurer Policy Details',
            'insurerPolicy' => $insurerPolicy,
        ]);
    }
}
