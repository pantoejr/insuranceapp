<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermission extends Component
{
    public $roleId;
    public $availablePermissions = [];
    public $selectedPermissions = [];

    public function mount($roleId)
    {
        $this->roleId = $roleId;

        $this->availablePermissions = Permission::pluck('name', 'id')->toArray();

        $this->selectedPermissions = $this->getRolePermissions()->toArray();
        $this->availablePermissions = array_diff_key($this->availablePermissions, array_flip($this->selectedPermissions));
    }

    public function render()
    {
        $role = Role::findById($this->roleId);

        if (!$role) {
            return abort(404);
        }

        return view('livewire.role.add-permission', [
            'role' => $role,
            'availablePermissions' => $this->availablePermissions,
            'selectedPermissions' => $this->selectedPermissions
        ]);
    }

    public function getRolePermissions()
    {
        return Role::findById($this->roleId)->permissions()->pluck('id');
    }

    public function submit()
    {
        $role = Role::findById($this->roleId);

        $role->syncPermissions($this->selectedPermissions);

        return redirect()->route('roles.details', $role->id)
            ->with('msg', 'Permissions assigned successfully!')
            ->with('flag', 'success');
    }
}
