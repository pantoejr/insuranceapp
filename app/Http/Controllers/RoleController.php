<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', [
            'title' => 'Roles',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('roles.create', [
            'title' => 'Create Role',
        ]);
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
            ]);
            Role::create($data);
            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $role = Role::find($id);
        return view('roles.details', [
            'title' => 'Edit Role',
            'role' => $role,
        ]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles.edit', [
            'title' => 'Edit Role',
            'role' => $role,
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::find($id);
        $data = $request->validate([
            'name' => 'required',
        ]);
        $role->update($data);
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully')
            ->with('flag', 'success');
    }
}
