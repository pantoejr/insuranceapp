<?php

namespace App\Http\Controllers;

use App\Models\PolicySubType;
use App\Models\PolicyType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PolicySubTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $policySubTypes = PolicySubType::all();
        return view('policy_sub_types.index', [
            'title' => 'Policy Sub Types',
            'policySubTypes' => $policySubTypes,
        ]);
    }

    public function create()
    {
        $policyTypes = PolicyType::all();
        return view('policy_sub_types.create', [
            'title' => 'Create Policy Sub Type',
            'policyTypes' => $policyTypes,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'policy_type_id' => 'required|exists:policy_types,id',
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        PolicySubType::create([
            'policy_type_id' => $validatedData['policy_type_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'created_by' => Auth::user()->name,
            'updated' => Auth::user()->name,
        ]);

        return redirect()->route('policySubTypes.index')
            ->with('msg', 'Policy Sub Type Created successfully')
            ->with('flag', 'success');
    }

    public function edit($id)
    {
        $policySubType = PolicySubType::find($id);
        return view('policy_sub_types.edit', [
            'title' => 'Edit Policy Sub Type',
            'policySubType' => $policySubType,
            'policyTypes' => PolicyType::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'policy_type_id' => 'required|exists:policy_types,id',
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $policySubType = PolicySubType::findOrFail($id);

        $policySubType->update([
            'policy_type_id' => $validatedData['policy_type_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'updated' => Auth::user()->name,
        ]);

        return redirect()->route('policySubTypes.index')
            ->with('msg', 'Policy Sub Type Updated successfully')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $policySubType = PolicySubType::findOrFail($id);

        $policySubType->delete();

        return redirect()->route('policySubTypes.index')
            ->with('msg', 'Policy Sub Type Deleted successfully')
            ->with('flag', 'success');
    }
}
