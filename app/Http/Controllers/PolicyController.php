<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\Policy;
use App\Models\PolicyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

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
        $policyTypes = PolicyType::with('policySubTypes')->get();
        return view('policies.create', [
            'title' => 'Create Policy',
            'policyTypes' => $policyTypes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'policy_name' => 'required',
            'policy_type_id' => 'required|exists:policy_types,id',
            'policy_sub_type_id' => 'nullable|exists:policy_sub_types,id',
            'number' => 'nullable|string|max:255|unique:policies',
            'description' => 'nullable|string',
            'coverage_details' => 'nullable|string',
            'premium_amount' => 'required|numeric',
            'premium_frequency' => 'required|string|max:255',
            'currency' => 'required|string|in:usd,lrd',
            'terms_conditions' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $policy = Policy::create([
                'policy_name' => $request->policy_name,
                'policy_type_id' => $request->policy_type_id,
                'number' => filled($request->number) ? $request->number : 'SIB' . Str::random(6),
                'description' => $request->description,
                'coverage_details' => $request->coverage_details,
                'premium_amount' => $request->premium_amount,
                'premium_frequency' => $request->premium_frequency,
                'currency' => $request->currency,
                'terms_conditions' => $request->terms_conditions,
                'eligibility' => $request->eligibility,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
                'policy_sub_type_id' => $request->input('policy_sub_type_id'),
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
        $policyTypes = PolicyType::with('policySubTypes')->get();
        return view('policies.edit', [
            'title' => 'Edit Policy',
            'policy' => $policy,
            'policyTypes' => $policyTypes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);
        try {

            $request->validate([
                'policy_name' => 'required',
                'policy_type_id' => 'required|exists:policy_types,id',
                'policy_sub_type_id' => 'nullable|exists:policy_sub_types,id',
                'number' => 'required|string|max:255|unique:policies,number,' . $policy->id,
                'description' => 'nullable|string',
                'coverage_details' => 'nullable|string',
                'premium_amount' => 'required|numeric',
                'currency' => 'required|string|in:usd,lrd',
                'terms_conditions' => 'nullable|string',
                'eligibility' => 'nullable|string',
                'status' => 'required|string|in:active,inactive',
            ]);

            $policy->update([
                'policy_name' => $request->policy_name,
                'policy_type_id' => $request->policy_type_id,
                'policy_sub_type_id' => $request->policy_sub_type_id,
                'number' => $request->number,
                'description' => $request->description,
                'coverage_details' => $request->coverage_details,
                'premium_amount' => $request->premium_amount,
                'premium_frequency' => $request->premium_frequency,
                'currency' => $request->currency,
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


    public function getInsurerPolicy($id)
    {
        $policies = Policy::join('insurer_policies', 'policies.id', '=', 'insurer_policies.policy_id')
            ->join('policy_types', 'policies.policy_type_id', '=', 'policy_types.id')
            ->join('policy_sub_types', 'policies.policy_sub_type_id', '=', 'policy_sub_types.id')
            ->where('insurer_policies.insurer_id', $id)
            ->where('insurer_policies.status', 'active')
            ->select('policies.id', 'policies.*', 'policy_types.*', 'policies.*', 'policy_sub_types.*')
            ->get();

        return response()->json($policies);
    }
}
