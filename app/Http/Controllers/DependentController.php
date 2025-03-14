<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Dependent;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class DependentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Employee $employee)
    {
        $dependents = $employee->dependents;
        return view('dependents.index', [
            'title' => 'Dependents',
            'employee' => $employee,
            'dependents' => $dependents,
        ]);
    }

    public function create(Employee $employee)
    {
        return view('dependents.create', [
            'title' => 'Create Dependent',
            'employee' => $employee,
        ]);
    }

    public function store(Request $request, Employee $employee)
    {
        $request->validate([
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

            $employee->dependents()->create([
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

            return redirect()->route('employees.details', ['client' => $employee->client_id, 'employee' => $employee->id])->with('msg', 'Dependent created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit(Employee $employee, Dependent $dependent)
    {
        return view('dependents.edit', [
            'title' => 'Edit Dependent',
            'employee' => $employee,
            'dependent' => $dependent,
        ]);
    }

    public function update(Request $request, Employee $employee, Dependent $dependent)
    {
        $request->validate([
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

            return redirect()->route('employees.details', ['client' => $employee->client_id, 'employee' => $employee->id])->with('msg', 'Dependent updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy(Employee $employee, Dependent $dependent)
    {
        try {
            Storage::disk('public')->delete($dependent->profile_picture);
            $dependent->delete();
            return redirect()->route('employees.details', ['client' => $employee->client_id, 'employee' => $employee->id])
                ->with('msg', 'Dependent deleted successfully')
                ->with('flag', 'danger');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while deleting the dependent: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details(Employee $employee, Dependent $dependent)
    {
        return view('dependents.details', [
            'title' => 'Dependent Details',
            'employee' => $employee,
            'dependent' => $dependent,
        ]);
    }

    public function addAttachment(Request $request,  Employee $employee, Dependent $dependent)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        try {
            $filePath = $request->file('file_path')->store('attachments', 'public');
            $fileType = mime_content_type($request->file('file_path')->getPathname());

            $attachment = new Attachment([
                'file_name' => $request->input('file_name') ?? $request->file('file_path')->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $fileType,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $dependent->attachments()->save($attachment);

            return response()->json(['msg' => 'Attachment added successfully.', 'flag' => 'success']);
        } catch (Exception $e) {
            return response()->json(['msg' => 'An error occurred while adding the attachment: ' . $e->getMessage(), 'flag' => 'danger']);
        }
    }
}
