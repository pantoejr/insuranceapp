<form wire:submit.prevent="submit">
    @csrf
    <div class="card card-danger card-outline mb-4">
        <div class="card-header">
            <div class="card-title">Remove Permissions for {{ $role->name }}</div>
        </div>
        <div class="card-body" style="overflow: auto; height: 300px;">
            @if ($rolePermissions->isEmpty())
                <p>No permissions available to revoke for this role.</p>
            @else
                @foreach ($rolePermissions as $permissionId => $permissionName)
                    <div class="form-group">
                        <input wire:model="removableSelectedPermissions" type="checkbox" value="{{ $permissionId }}"
                            id="permission-{{ $permissionId }}" />
                        <label for="permission-{{ $permissionId }}">{{ $permissionName }}</label>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
    @if (!empty($rolePermissions))
        <button type="submit" class="btn btn-danger w-100">Revoke Permissions</button>
    @endif
</form>
