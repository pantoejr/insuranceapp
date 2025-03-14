<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Client;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Client $client)
    {
        $employees = $client->employees;
        return view('employees.index', [
            'title' => 'Employees',
            'client' => $client,
            'employees' => $employees,
        ]);
    }

    public function create(Client $client)
    {
        return view('employees.create', [
            'title' => 'Create Employee',
            'client' => $client,
        ]);
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'address' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $profilePicturePath = $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures', 'public') : null;

            $client->employees()->create([
                'employee_name' => $request->employee_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                'gender' => $request->gender,
                'address' => $request->address,
                'status' => $request->status,
                'profile_picture' => $profilePicturePath,
                'date_of_birth' => $request->date_of_birth,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('clients.details', ['id' => $client->id])->with('msg', 'Employee created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the employee: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit(Client $client, Employee $employee)
    {
        return view('employees.edit', [
            'title' => 'Edit Employee',
            'client' => $client,
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, Client $client, Employee $employee)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'address' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $profilePicturePath = $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures', 'public') : $employee->profile_picture;

            $employee->update([
                'employee_name' => $request->employee_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                'gender' => $request->gender,
                'address' => $request->address,
                'status' => $request->status,
                'profile_picture' => $profilePicturePath,
                'date_of_birth' => $request->date_of_birth,
                'updated_by' => Auth::user()->name,
            ]);

            return redirect()->route('clients.details', ['id' => $client->id])->with('msg', 'Employee updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the employee: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details(Client $client, Employee $employee)
    {
        return view('employees.details', [
            'title' => 'Employee Details',
            'client' => $client,
            'employee' => $employee,
        ]);
    }

    public function destroy(Client $client, Employee $employee)
    {
        $employee->delete();
        return redirect()->route('clients.details', ['id' => $client->id])
            ->with('msg', 'Employee deleted successfully')
            ->with('flag', 'success');
    }

    public function addAttachment(Request $request, Client $client, Employee $employee)
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

            $employee->attachments()->save($attachment);

            return response()->json(['msg' => 'Attachment added successfully.', 'flag' => 'success']);
        } catch (Exception $e) {
            return response()->json(['msg' => 'An error occurred while adding the attachment: ' . $e->getMessage(), 'flag' => 'danger']);
        }
    }
}
