<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $claims = Claim::all();
        return view('claims.index', [
            'title' => 'Claims',
            'claims' => $claims,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'policy_id' => 'required|exists:policies,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'claim_type' => 'required|string',
            'description' => 'required|string',
            'claim_documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $validatedData['created_by'] = Auth::user()->name;
        $validatedData['updated_by'] = Auth::user()->name;
        $validatedData['status'] = 'Pending Review';

        $claim = Claim::create($validatedData);

        if ($request->hasFile('claim_documents')) {
            foreach ($request->file('claim_documents') as $file) {
                $filePath = $file->store('attachments', 'public');
                $fileType = mime_content_type($file->getPathname());

                $attachment = new Attachment([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);

                $claim->attachments()->save($attachment);
            }
        }

        return response()->json(['msg' => 'Claim created successfully.', 'flag' => 'success']);
    }

    public function details($id)
    {
        $claim = Claim::findOrFail($id);
        return response()->json($claim);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'client_id' => 'required',
            'policy_id' => 'required',
            'amount' => 'required|numeric',
            'currency' => 'required',
            'claim_type' => 'required',
            'description' => 'required',
            'status' => 'required',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);

        $claim = Claim::findOrFail($id);
        $claim->update($validatedData);
        return response()->json($claim);
    }

    public function destroy($id)
    {
        $claim = Claim::findOrFail($id);
        $claim->delete();
        return response()->json(null, 204);
    }
}
