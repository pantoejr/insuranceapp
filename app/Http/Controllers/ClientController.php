<?php

namespace App\Http\Controllers;

use App\Helpers\SmsHelper;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $clients = Client::all();
        return view('clients.index', [
            'title' => 'Clients',
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'title' => 'Create Client',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'photo_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        try {
            $photoPath = $request->file('photo_picture') ? $request->file('photo_picture')->store('photos', 'public') : null;

            Client::create([
                'client_type' => $request->client_type,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'photo_picture' => $photoPath,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            //SmsHelper::sendSms($request->phone, 'Welcome to our service! Your account has been created successfully.');
        } catch (Exception $ex) {
            return back()->with('msg', 'An error occurred while creating the client: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        return redirect()->route('clients.index')->with('msg', 'Client created successfully.')->with('flag', 'success');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', [
            'title' => 'Edit Client',
            'client' => $client,
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $request->validate([
            'client_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'photo_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        try {
            if ($request->hasFile('photo_picture')) {
                $photoPath = $request->file('photo_picture')->store('photos', 'public');
                $client->photo_picture = $photoPath;
            }

            $client->update([
                'client_type' => $request->client_type,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'updated_by' => Auth::user()->name,
            ]);
        } catch (Exception $ex) {
            return back()->with('msg', 'An error occurred while updating the client: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        return redirect()->route('clients.index')->with('msg', 'Client updated successfully.');
    }

    // public function destroy($id)
    // {
    //     $client = Client::findOrFail($id);
    //     $client->status = 'inactive';
    //     $client->save();
    //     return redirect()->route('clients.index')->with('msg', 'Client deleted successfully.');
    // }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index')->with('msg', 'Client deleted successfully.')
            ->with('flag', 'success');
    }

    public function details($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.details', [
            'title' => 'Client Details',
            'model' => $client,
        ]);
    }

    public function addAttachment(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        try {
            $client = Client::findOrFail($id);
            $filePath = $request->file('file_path')->store('attachments', 'public');
            $fileType = mime_content_type($request->file('file_path')->getPathname());

            $attachment = new Attachment([
                'file_name' => $request->input('file_name') ?? $request->file('file_path')->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $fileType,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $client->attachments()->save($attachment);

            return response()->json(['msg' => 'Attachment added successfully.', 'flag' => 'success']);
        } catch (Exception $e) {
            return response()->json(['msg' => 'An error occurred while adding the attachment: ' . $e->getMessage(), 'flag' => 'danger']);
        }
    }
}
