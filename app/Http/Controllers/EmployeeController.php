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
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', [
            'title' => 'Employees',
            'employees' => $employees,
        ]);
    }

    public function create($clientId = null)
    {
        $client = Client::where('status', 'active')->get();
        return view('employees.create', [
            'title' => 'Create Employee',
            'clients' => $client,
            'clientId' => $clientId ?? null,
        ]);
    }

    public function store(Request $request, $clientId = null)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
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

            $employee = Employee::create([
                'client_id' => $request->client_id,
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

            if ($clientId) {
                return redirect()->route('clients.details', ['id' => $clientId])->with('msg', 'Employee created successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('employees.index')->with('msg', 'Employee created successfully.')
                    ->with('flag', 'success');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the employee: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id, $clientId = null)
    {
        $employee = Employee::findOrFail($id);
        $clients = Client::all();
        return view('employees.edit', [
            'title' => 'Edit Employee',
            'employee' => $employee,
            'clients' => $clients,
            'clientId' => $clientId
        ]);
    }

    public function update(Request $request, $id, $clientId = null)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
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
                'client_id' => $request->client_id,
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

            if ($clientId) {
                return redirect()->route('clients.details', ['id' => $clientId])->with('msg', 'Employee updated successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('employees.index')->with('msg', 'Employee updated successfully.')
                    ->with('flag', 'success');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while updating the employee: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id, $clientId = null)
    {
        $employee = Employee::findOrFail($id);
        $clients = Client::all();
        return view('employees.details', [
            'title' => 'Employee Details',
            'employee' => $employee,
            'clients' => $clients,
            'clientId' => $clientId
        ]);
    }

    public function destroy($id, $clientId = null)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        if ($clientId) {
            return redirect()->route('clients.details', ['id' => $clientId])
                ->with('msg', 'Employee deleted successfully')
                ->with('flag', 'danger');
        } else {
            return redirect()->route('employees.index')
                ->with('msg', 'Employee deleted successfully')
                ->with('flag', 'danger');
        }
    }

    public function deactivate($id, $clientId = null)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = 'active';
        $employee->save();

        if ($clientId) {
            return redirect()->route('clients.details', ['id' => $clientId])
                ->with('msg', 'Employee deleted successfully')
                ->with('flag', 'danger');
        } else {
            return redirect()->route('employees.index')
                ->with('msg', 'Employee deleted successfully')
                ->with('flag', 'danger');
        }
    }

    public function addAttachment(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        try {
            $employee = Employee::findOrFail($id);
            $filePath = $request->file('file_path')->store('attachments', 'public');
            $fileType = mime_content_type($request->file('file_path')->getPathname());

            $attachment = new Attachment([
                'file_path' => $filePath,
                'file_type' => $fileType,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $employee->attachments()->save($attachment);

            return redirect()->route('employees.details', $id)->with('msg', 'Attachment added successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while adding the attachment: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }
}
