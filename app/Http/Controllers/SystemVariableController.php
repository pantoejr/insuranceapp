<?php

namespace App\Http\Controllers;

use App\Models\SystemVariable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SystemVariableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $systemVariables = SystemVariable::all();
        return view('system_variables.index', [
            'title' => 'System Variables',
            'systemVariables' => $systemVariables,
        ]);
    }

    public function create()
    {
        return view('system_variables.create', [
            'title' => 'Create System Variable',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'type' => 'required|in:name,sname,email,address,phone,mobile,logo',
                'value' => 'required',
            ]
        );

        try {

            if ($validatedData['type'] === 'logo' && $request->hasFile('value')) {
                $filePath = $request->file('value')->store('system_variable', 'public');
                $validatedData['value'] = $filePath;
            }

            $systemVariable = new SystemVariable([
                'name' => $validatedData['name'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $systemVariable->save();

            return redirect()->route('system-variables.index')
                ->with('msg', 'System variable created successfully')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error creating system variable: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $systemVariable = SystemVariable::findOrFail($id);
        return view('system_variables.details', [
            'title' => 'System Variable Details',
            'systemVariable' => $systemVariable,
        ]);
    }

    public function edit($id)
    {
        $systemVariable = SystemVariable::findOrFail($id);

        return view('system_variables.edit', [
            'title' => 'Edit System Variable',
            'systemVariable' => $systemVariable,
        ]);
    }

    public function update(Request $request, $id)
    {
        $systemVariable = SystemVariable::findOrFail($id);
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'type' => 'required|in:name,sname,email,address,phone,mobile,logo',
                'value' => 'required',
            ]
        );

        try {
            if ($validatedData['type'] === 'logo' && $request->hasFile('value')) {
                if ($systemVariable->value && Storage::disk('public')->exists($systemVariable->value)) {
                    Storage::disk('public')->delete($systemVariable->value);
                }

                $filePath = $request->file('value')->store('system_variable', 'public');
                $validatedData['value'] = $filePath;
            }

            $systemVariable->name = $validatedData['name'];
            $systemVariable->type = $validatedData['type'];
            $systemVariable->value = $validatedData['value'];
            $systemVariable->updated_by = Auth::user()->name;
            $systemVariable->save();

            return redirect()->route('system-variables.index')
                ->with('msg', 'System variable updated successfully')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error updating system variable: ' . $ex->getMessage());

            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        try {
            $systemVariable = SystemVariable::findOrFail($id);

            if ($systemVariable->type === 'logo' && $systemVariable->value) {
                Storage::disk('public')->delete($systemVariable->value);
            }

            $systemVariable->delete();

            return redirect()->route('system-variables.index')
                ->with('msg', 'System variable deleted successfully')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            Log::error('Error deleting system variable: ' . $ex->getMessage());
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }
}
