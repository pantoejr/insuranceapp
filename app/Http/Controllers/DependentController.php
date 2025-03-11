<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Dependent;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DependentController extends Controller
{
    public function index()
    {
        $dependents = Dependent::all();
        return view('dependents.index', [
            'title' => 'Dependents',
            'dependents' => $dependents,
        ]);
    }

    public function create($employeeId = null, $clientId = null)
    {
        $employees = Employee::all();
        return view('dependents.create', [
            'title' => 'Create Dependent',
            'employees' => $employees,
            'employeeId' => $employeeId,
            'clientId' => $clientId,
        ]);
    }

    public function store(Request $request, $employeeId = null, $clientId = null)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'dependent_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255|unique:dependents',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $profilePicturePath = $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures', 'public') : null;

            $dependent = Dependent::create([
                'employee_id' => $request->employee_id,
                'dependent_name' => $request->dependent_name,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'relationship' => $request->relationship,
                'profile_picture' => $profilePicturePath,
                'status' => $request->status,
                'date_of_birth' => $request->date_of_birth,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            if ($employeeId) {
                return redirect()->route('employees.details', ['id' => $employeeId, 'clientId' => $clientId])->with('msg', 'Dependent created successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('dependents.index')->with('msg', 'Dependent created successfully.')
                    ->with('flag', 'success');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id, $employeeId = null, $clientId = null)
    {
        $dependent = Dependent::findOrFail($id);
        $employees = Employee::all();
        return view('dependents.edit', [
            'title' => 'Edit Dependent',
            'dependent' => $dependent,
            'employees' => $employees,
            'employeeId' => $employeeId,
            'clientId' => $clientId,
        ]);
    }

    public function update(Request $request, $id, $employeeId = null, $clientId = null)
    {
        $dependent = Dependent::findOrFail($id);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'dependent_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255|unique:dependents,email,' . $dependent->id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $profilePicturePath = $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures', 'public') : $dependent->profile_picture;

            $dependent->update([
                'employee_id' => $request->employee_id,
                'dependent_name' => $request->dependent_name,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'relationship' => $request->relationship,
                'profile_picture' => $profilePicturePath,
                'status' => $request->status,
                'date_of_birth' => $request->date_of_birth,
                'updated_by' => Auth::user()->name,
            ]);

            if ($employeeId) {
                return redirect()->route('employees.details', ['id' => $employeeId, 'clientId' => $clientId])->with('msg', 'Dependent updated successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('dependents.index')->with('msg', 'Dependent updated successfully.')
                    ->with('flag', 'success');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id, $employeeId = null, $clientId = null)
    {
        try {
            $dependent = Dependent::findOrFail($id);
            $dependent->delete();

            if ($employeeId) {
                return redirect()->route('employees.details', ['id' => $employeeId, 'clientId' => $clientId])->with('msg', 'Dependent deleted successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('dependents.index')->with('msg', 'Dependent deleted successfully.')
                    ->with('flag', 'success');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id, $employeeId = null, $clientId = null)
    {
        $dependent = Dependent::findOrFail($id);
        return view('dependents.details', [
            'title' => 'Dependent Details',
            'dependent' => $dependent,
            'employeeId' => $employeeId,
            'clientId' => $clientId,
        ]);
    }

    public function addAttachment(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        try {
            $dependent = Dependent::findOrFail($id);
            $filePath = $request->file('file_path')->store('attachments', 'public');
            $fileType = mime_content_type($request->file('file_path')->getPathname());

            $attachment = new Attachment([
                'file_path' => $filePath,
                'file_type' => $fileType,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $dependent->attachments()->save($attachment);

            return redirect()->route('dependents.details', $id)->with('msg', 'Attachment added successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while adding the attachment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }
}
