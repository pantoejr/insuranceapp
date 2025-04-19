<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\InsurerAssignment;
use App\Models\InsurerPolicy;
use App\Models\Policy;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class InsurerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $insurers = Insurer::all();
        return view('insurers.index', [
            'title' => 'Insurers',
            'insurers' => $insurers,
        ]);
    }

    public function create()
    {
        return view('insurers.create', [
            'title' => 'Create Insurer',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:insurers',
            'phone' => 'required|string|max:255',
            'key_contact_person' => 'required|string|max:255',
            'key_contact_email' => 'required|string|email|max:255',
            'description' => 'nullable|string',
            'website_url' => 'nullable|string|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $logoPath = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : null;

            $insurer = Insurer::create([
                'company_name' => $request->company_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'key_contact_person' => $request->key_contact_person,
                'key_contact_email' => $request->key_contact_email,
                'description' => $request->description,
                'website_url' => $request->website_url,
                'logo' => $logoPath,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return to_route('insurers.index')->with('msg', 'Insurer created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the insurer: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $insurer = Insurer::findOrFail($id);
        return view('insurers.edit', [
            'title' => 'Edit Insurer',
            'insurer' => $insurer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $insurer = Insurer::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:insurers,email,' . $insurer->id,
            'phone' => 'required|string|max:255',
            'key_contact_person' => 'required|string|max:255',
            'key_contact_email' => 'required|string|email|max:255',
            'description' => 'nullable|string',
            'website_url' => 'nullable|string|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $logoPath = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : $insurer->logo;

            $insurer->update([
                'company_name' => $request->company_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'key_contact_person' => $request->key_contact_person,
                'key_contact_email' => $request->key_contact_email,
                'description' => $request->description,
                'website_url' => $request->website_url,
                'logo' => $logoPath,
                'status' => $request->status,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurers.index')->with('msg', 'Insurer updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the insurer: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $insurer = Insurer::findOrFail($id);
            $insurer->delete();

            return redirect()->route('insurers.index')->with('msg', 'Insurer deleted successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the insurer: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $insurer = Insurer::findOrFail($id);
        $policies = Policy::where('status', 'active')->get();
        $users = User::where('status', 'active')->get();
        return view('insurers.details', [
            'title' => 'Insurer Details',
            'insurer' => $insurer,
            'policies' => $policies,
            'users' => $users,
        ]);
    }

    public function editPolicy($id)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        return response()->json($insurerPolicy);
    }

    public function updatePolicy(Request $request, $id)
    {
        $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'status' => 'required|in:active,inactive',
        ]);

        $insurerPolicy = InsurerPolicy::findOrFail($id);

        $insurerPolicy->update([
            'policy_id' => $request->policy_id,
            'status' => $request->status,
            'updated_by' => Auth::user()->name,
        ]);

        return response()->json(['message' => 'Policy updated successfully']);
    }

    public function addInsurerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insurer_id' => 'required|exists:insurers,id',
            'name' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'email' => 'email|required',
            'phone' => 'required|string|max:20',
    
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        InsurerAssignment::create([
            'insurer_id' => $request->insurer_id,
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'phone' => $request->phone,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        return response()->json(['message' => 'User added successfully']);
    }

    public function editInsurerUser($id)
    {
        $insurerUser = InsurerAssignment::findOrFail($id);
        return response()->json($insurerUser);
    }

    public function updateInsurerUser(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'edited_status' => 'required|in:active,inactive',
            'edited_name' => 'required|string|max:50',
            'edited_email' => 'unique:insurer_assignments,email,except,id',
            'edited_phone' => 'unique:insurer_assignments,phone,except,id'
        ]);

        try {
            $insurerUser = InsurerAssignment::findOrFail($id);
            $insurerUser->update([
                'name' => $request->edited_name,
                'status' => $request->edited_status,
                'phone' => $request->edited_phone,
                'email' => $request->edited_email,
                'updated_by' => Auth::user()->id,
            ]);

            // Return a success response
            return response()->json(['message' => 'User updated successfully']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Insurer user not found.',
            ], 404);
        }
    }

    public function storeMultiplePolicies(Request $request)
    {
        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'policy_ids' => 'required|array',
            'policy_ids.*' => 'exists:policies,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            foreach ($request->policy_ids as $policyId) {
                InsurerPolicy::create([
                    'insurer_id' => $request->insurer_id,
                    'policy_id' => $policyId,
                    'status' => $request->status,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);
            }

            return response()->json(['msg' => 'Policies assigned successfully.', 'flag' => 'success']);
        } catch (Exception $e) {
            return response()->json(['msg' => 'An error occurred while adding the policies: ' . $e->getMessage(), 'flag' => 'danger']);
        }
    }

    public function removeInsurerPolicy($id, $insurerId)
    {
        $insurerPolicy = InsurerPolicy::findOrFail($id);
        $insurerPolicy->delete();
        return redirect()->route('insurers.details', ['id' => $insurerId])
            ->with('msg', 'Insurer Policy removed successfully')
            ->with('flag', 'success');
    }
}
