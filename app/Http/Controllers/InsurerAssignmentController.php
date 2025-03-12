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
    public function index()
    {
        $assignments = InsurerAssignment::all();
        return view('insurer_assignments.index', [
            'title' => 'Insurer Assignments',
            'assignments' => $assignments,
        ]);
    }

    public function create()
    {
        $insurers = Insurer::all();
        $users = User::all();
        return view('insurer_assignments.create', [
            'title' => 'Create Insurer Assignment',
            'insurers' => $insurers,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $assignment = InsurerAssignment::create([
                'insurer_id' => $request->insurer_id,
                'user_id' => $request->user_id,
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurer_assignments.index')->with('msg', 'Insurer Assignment created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the insurer assignment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $assignment = InsurerAssignment::findOrFail($id);
        return view('insurer_assignments.edit', [
            'title' => 'Edit Insurer Assignment',
            'assignment' => $assignment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $assignment = InsurerAssignment::findOrFail($id);

        $request->validate([
            'insurer_id' => 'required|exists:insurers,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $assignment->update([
                'insurer_id' => $request->insurer_id,
                'user_id' => $request->user_id,
                'status' => $request->status,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('insurer_assignments.index')->with('msg', 'Insurer Assignment updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the insurer assignment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $assignment = InsurerAssignment::findOrFail($id);
            $assignment->delete();

            return redirect()->route('insurer_assignments.index')->with('msg', 'Insurer Assignment deleted successfully.')
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
