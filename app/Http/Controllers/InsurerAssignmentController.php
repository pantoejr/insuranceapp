<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use App\Models\InsurerAssignment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class InsurerAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Insurer $insurer)
    {
        $assignments = InsurerAssignment::all();
        return view('insurer_assignments.index', [
            'title' => 'Insurer Assignments',
            'assignments' => $assignments,
            'insurer' => $insurer,
        ]);
    }

    public function create(Insurer $insurer)
    {
        $users = User::all();
        return view('insurer_assignments.create', [
            'title' => 'Create Insurer Assignment',
            'insurers' => $insurer,
            'users' => $users,
        ]);
    }

    public function store(Request $request, Insurer $insurer)
    {
        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:uploader,approver,reviewer,final_approver',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $assignment = InsurerAssignment::create([
                'insurer_id' => $request->insurer_id,
                'user_id' => $request->user_id,
                'role' => $request->role,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurers.details', ['id' => $insurer->id])->with('msg', 'Insurer Assignment created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the insurer assignment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit(Insurer $insurer, InsurerAssignment $insurerAssignment)
    {
        $users = User::all();
        return view('insurer_assignments.edit', [
            'title' => 'Edit Insurer Assignment',
            'assignment' => $insurerAssignment,
            'insurer' => $insurer,
            'users' => $users,
        ]);
    }

    public function update(Request $request, Insurer $insurer, InsurerAssignment $insurerAssignment)
    {

        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'user_id' => 'required|exists:users,id',
            'edited_role_status' => 'required|string|in:uploader,approver,reviewer,final_approver',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $insurerAssignment->update([
                'insurer_id' => $request->insurer_id,
                'user_id' => $request->user_id,
                'role' => $request->role,
                'status' => $request->edited_role_status,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurers.details', ['id' => $insurer->id])->with('msg', 'Insurer Assignment updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the insurer assignment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy(Insurer $insurer, InsurerAssignment $insurerAssignment)
    {
        try {
            $insurerAssignment->delete();

            return redirect()->route('insurers.details', ['id' => $insurer->id])->with('msg', 'Insurer Assignment deleted successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the insurer assignment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $assignment = InsurerAssignment::findOrFail($id);
        return view('insurer_assignments.details', [
            'title' => 'Insurer Assignment Details',
            'assignment' => $assignment,
        ]);
    }
}
