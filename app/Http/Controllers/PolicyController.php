<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\Policy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PolicyController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $policies = Policy::all();
        return view('policies.index', [
            'title' => 'Policies',
            'policies' => $policies,
        ]);
    }

    public function create()
    {
        return view('policies.create', [
            'title' => 'Create Policy',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255|unique:policies',
            'description' => 'nullable|string',
            'coverage_details' => 'nullable|string',
            'premium_amount' => 'required|numeric',
            'premium_frequency' => 'required|string|max:255',
            'policy_duration' => 'required|string|max:255',
            'terms_conditions' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $policy = Policy::create([
                'name' => $request->name,
                'number' => $request->number,
                'description' => $request->description,
                'coverage_details' => $request->coverage_details,
                'premium_amount' => $request->premium_amount,
                'premium_frequency' => $request->premium_frequency,
                'policy_duration' => $request->policy_duration,
                'terms_conditions' => $request->terms_conditions,
                'eligibility' => $request->eligibility,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('policies.index')->with('msg', 'Policy created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $policy = Policy::findOrFail($id);
        return view('policies.edit', [
            'title' => 'Edit Policy',
            'policy' => $policy,
        ]);
    }

    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255|unique:policies,number,' . $policy->id,
            'description' => 'nullable|string',
            'coverage_details' => 'nullable|string',
            'premium_amount' => 'required|numeric',
            'premium_frequency' => 'required|string|max:255',
            'policy_duration' => 'required|string|max:255',
            'terms_conditions' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $policy->update([
                'name' => $request->name,
                'number' => $request->number,
                'description' => $request->description,
                'coverage_details' => $request->coverage_details,
                'premium_amount' => $request->premium_amount,
                'premium_frequency' => $request->premium_frequency,
                'policy_duration' => $request->policy_duration,
                'terms_conditions' => $request->terms_conditions,
                'eligibility' => $request->eligibility,
                'status' => $request->status,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('policies.index')->with('msg', 'Policy updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $policy = Policy::findOrFail($id);
            $policy->delete();

            return redirect()->route('policies.index')->with('msg', 'Policy deleted successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the policy: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $policy = Policy::findOrFail($id);
        $insurers = Insurer::all();
        return view('policies.details', [
            'title' => 'Policy Details',
            'policy' => $policy,
            'insurers' => $insurers,
        ]);
    }
}
