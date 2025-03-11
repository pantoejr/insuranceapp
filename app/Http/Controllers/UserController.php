<?php

namespace App\Http\Controllers;

use App\Mail\UserWelcomeEmail;
use App\Models\User;
use App\Services\EmailServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Email;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('users.index', [
            'title' => 'Users List',
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', [
            'title' => 'Create User',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'roleId' => 'required',
        ]);

        try {
            $photoPath = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null;

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'photo' => $photoPath,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'login_hint' => $request->input('password'),
                'status' => $request->status,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            $role = Role::findById($request->roleId);
            $user->assignRole($role);

            //$this->emailService->sendWelcomeEmail($user);

            Mail::to($user->email)->send(new UserWelcomeEmail($user));

            return redirect()->route('users.index')->with('msg', 'User created successfully.')
                ->with('flag', 'success');
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'An error occurred while creating the user: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('users.details', [
            'title' => 'User Details',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'roleId' => 'required',
        ]);

        try {
            $photoPath = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : $user->photo;

            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'photo' => $photoPath,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'login_hint' => $request->login_hint,
                'status' => $request->status,
                'updated_by' => Auth::user()->name,
            ]);

            $role = Role::findById($request->roleId);
            $user->syncRoles($role);

            return redirect()->route('users.index')->with('msg', 'User updated successfully.')
                ->with('flag', 'success');
        } catch (\Exception $e) {
            return redirect()->route('users.edit', $user->id)->with('error', 'An error occurred while updating the user: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();
        return redirect()->route('users.index')->with('msg', 'User deactivated successfully.')
            ->with('flag', 'success');
    }

    public function refreshPermissions($id)
    {
        try {
            $user = User::findOrFail($id);
            $role = $user->roles->first();

            if ($role) {
                $permissions = $role->permissions;
                $role->syncPermissions($permissions);

                return redirect()->route('users.details', $id)->with('msg', 'Permissions refreshed successfully.')
                    ->with('flag', 'success');
            } else {
                return redirect()->route('users.details', $id)->with('msg', 'User has no role assigned.')
                    ->with('flag', 'danger');
            }
        } catch (Exception $e) {
            return redirect()->route('users.details', $id)->with('msg', 'An error occurred while refreshing permissions: ' . $e->getMessage())
                ->with('flag', 'danger');
        }
    }
}
