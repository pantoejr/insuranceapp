<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
     public function index()
     {
          $attachments = Attachment::all();
          return view('attachments.index', [
               'title' => 'Attachments',
               'attachments' => $attachments,
          ]);
     }

     public function create()
     {
          return view('attachments.create', [
               'title' => 'Create Attachment',
          ]);
     }

     public function store(Request $request)
     {
          $request->validate([
               'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
               'file_type' => 'required|string|max:255',
               'attachmentable_type' => 'required|string|max:255',
               'attachmentable_id' => 'required|integer',
          ]);

          try {
               $filePath = $request->file('file_path')->store('attachments', 'public');

               $attachment = Attachment::create([
                    'file_path' => $filePath,
                    'file_type' => $request->file_type,
                    'attachmentable_type' => $request->attachmentable_type,
                    'attachmentable_id' => $request->attachmentable_id,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
               ]);

               return redirect()->route('attachments.index')->with('msg', 'Attachment created successfully.')
                    ->with('flag', 'success');
          } catch (Exception $e) {
               return redirect()->back()->with('msg', 'An error occurred while creating the attachment: ' . $e->getMessage())
                    ->with('flag', 'danger');
          }
     }

     public function edit($id)
     {
          $attachment = Attachment::findOrFail($id);
          return view('attachments.edit', [
               'title' => 'Edit Attachment',
               'attachment' => $attachment,
          ]);
     }

     public function update(Request $request, $id)
     {
          $attachment = Attachment::findOrFail($id);

          $request->validate([
               'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
               'file_type' => 'required|string|max:255',
               'attachmentable_type' => 'required|string|max:255',
               'attachmentable_id' => 'required|integer',
          ]);

          try {
               $filePath = $attachment->file_path;
               if ($request->hasFile('file_path')) {
                    $filePath = $request->file('file_path')->store('attachments', 'public');
               }

               $attachment->update([
                    'file_path' => $filePath,
                    'file_type' => $request->file_type,
                    'attachmentable_type' => $request->attachmentable_type,
                    'attachmentable_id' => $request->attachmentable_id,
                    'updated_by' => Auth::user()->name,
               ]);

               return redirect()->route('attachments.index')->with('msg', 'Attachment updated successfully.')
                    ->with('flag', 'success');
          } catch (Exception $e) {
               return redirect()->back()->with('msg', 'An error occurred while updating the attachment: ' . $e->getMessage())
                    ->with('flag', 'danger');
          }
     }

     public function destroy($id, $clientId = null)
     {
          try {
               $attachment = Attachment::findOrFail($id);
               Storage::disk('public')->delete($attachment->file_path);
               $attachment->delete();

               if ($clientId) {
                    return redirect()->route('clients.details', ['id' => $clientId])->with('msg', 'Attachment deleted successfully.')
                         ->with('flag', 'success');
               } else {
                    return redirect()->route('attachments.index')->with('msg', 'Attachment deleted successfully.')
                         ->with('flag', 'success');
               }
          } catch (Exception $e) {
               return redirect()->back()->with('msg', 'An error occurred while deleting the attachment: ' . $e->getMessage())
                    ->with('flag', 'danger');
          }
     }

     public function details($id)
     {
          $attachment = Attachment::findOrFail($id);
          return view('attachments.details', [
               'title' => 'Attachment Details',
               'attachment' => $attachment,
          ]);
     }
}
