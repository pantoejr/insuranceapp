<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\InsurerPolicy;
use App\Models\Policy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
            'insurer_id' => 'required|array',
            'insurer_id.*' => 'exists:insurers,id',
            'policy_id' => 'required|exists:policies,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            foreach ($request->insurer_id as $insurerId) {
                InsurerPolicy::create([
                    'insurer_id' => $insurerId,
                    'policy_id' => $request->policy_id,
                    'status' => $request->status,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);
            }

            return response()->json(['msg' => 'Policy assigned successfully.', 'flag' => 'success']);
        } catch (Exception $e) {
            return response()->json(['msg' => 'An error occurred while adding the policy: ' . $e->getMessage(), 'flag' => 'danger']);
        }
    }

    public function edit($id)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        return response()->json($insurerPolicy);
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

            return response()->json([
                'success' => true,
                'message' => 'Claim updated successfully',
                'data' => null,
            ], status: 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        $insurerPolicy->delete();
        return response()->json(null, 204);
    }

    public function details($id)
    {
        $insurerPolicy = InsurerPolicy::with(['policy.policyType', 'insurer'])->where('id', $id)->first();
        return response()->json($insurerPolicy);
    }
}
