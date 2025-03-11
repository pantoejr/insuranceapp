<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsurerController extends Controller
{
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
            'registration_number' => 'required|string|max:255',
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
                'registration_number' => $request->registration_number,
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

            return redirect()->route('insurers.index')->with('msg', 'Insurer created successfully.')
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
            'registration_number' => 'required|string|max:255',
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
                'registration_number' => $request->registration_number,
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
        return view('insurers.details', [
            'title' => 'Insurer Details',
            'insurer' => $insurer,
        ]);
    }
}
