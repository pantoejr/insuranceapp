<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $emailSettings = EmailSetting::all();
        return view('emailsettings.index', [
            'title' => 'Email Settings',
            'emailSettings' => $emailSettings,
        ]);
    }

    public function create()
    {
        return view('emailsettings.create', [
            'title' => 'Create Email Setting',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|string|max:255',
            'from_address' => 'required|string|email|max:255',
            'from_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            EmailSetting::create([
                'driver' => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'status' => $request->status,
                'created_by' => 'system',
                'updated_by' => 'system',
            ]);

            return redirect()->route('email-settings.index')
                ->with('msg', 'Email setting created successfully.')
                ->with('flag', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the email setting: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        return view('emailsettings.edit', [
            'title' => 'Edit Email Setting',
            'emailSetting' => $emailSetting,
        ]);
    }

    public function update(Request $request, $id)
    {
        $emailSetting = EmailSetting::findOrFail($id);

        $request->validate([
            'driver' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|string|max:255',
            'from_address' => 'required|string|email|max:255',
            'from_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $emailSetting->update([
                'driver' => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'status' => $request->status,
                'updated_by' => 'system',
            ]);

            return redirect()->route('email-settings.index')->with('success', 'Email setting updated successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the email setting: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        return view('emailsettings.details', [
            'title' => 'Email Setting Details',
            'emailSetting' => $emailSetting,
        ]);
    }

    public function destroy($id)
    {
        $emailSetting = EmailSetting::findOrFail($id);
        $emailSetting->delete();
        return redirect()->route('email-settings.index')->with('success', 'Email setting deleted successfully.')
            ->with('flag', 'success');
    }
}
