<?php

namespace App\Http\Controllers;

use App\Models\PolicyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PolicyTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $policyTypes = PolicyType::all();
        return view('policy_types.index', [
            'title' => 'Policy Types',
            'policyTypes' => $policyTypes,
        ]);
    }

    public function create()
    {
        return view('policy_types.create', [
            'title' => 'Create Policy Type',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        PolicyType::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()->route('policy-types.index')
            ->with('msg', 'Policy type created successfully')
            ->with('flag', 'success');
    }

    public function edit($id)
    {
        $policyType = PolicyType::find($id);
        return view('policy_types.edit', [
            'title' => 'Edit Policy Type',
            'policyType' => $policyType,
        ]);
    }

    public function update(Request $request, $id)
    {
        $policyType = PolicyType::find($id);
        $policyType->name = $request->name;
        $policyType->description = $request->description;
        $policyType->save();

        return redirect()->route('policy-types.index')
            ->with('msg', 'Policy type updated successfully')
            ->with('flag', 'success');
    }

    public function show($id)
    {
        $policyType = PolicyType::find($id);
        return view('policy_types.show', [
            'title' => 'Policy Type Details',
            'policyType' => $policyType,
        ]);
    }

    public function destroy($id)
    {
        $policyType = PolicyType::find($id);
        $policyType->delete();
        return redirect()->route('policy-types.index')
            ->with('msg', 'Policy type deleted successfully')
            ->with('flag', 'success');
    }
}
