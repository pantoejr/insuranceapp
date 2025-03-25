<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', [
            'title' => 'Permissions',
            'permissions' => $permissions,
        ]);
    }

    public function create()
    {
        return view('permissions.create', [
            'title' => 'Create Permission',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
            ]);
            Permission::create($data);
            return redirect()->route('permissions.create')
                ->with('msg', 'Permission created successfully')
                ->with('flag', 'success');
        } catch (Exception $ex) {
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', [
            'title' => 'Edit Permission',
            'permission' => $permission,
        ]);
    }

    public function update($id, Request $request)
    {
        $permission = Permission::find($id);
        $data = $request->validate([
            'name' => 'required',
        ]);
        $permission->update($data);
        return redirect()->route('permissions.index')
            ->with('msg', 'Permission updated successfully')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.index')
            ->with('msg', 'Permission deleted successfully')
            ->with('flag', 'success');
    }
}
