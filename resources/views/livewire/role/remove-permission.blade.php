<form wire:submit.prevent="submit">
    @csrf
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
        <button type="submit" class="btn btn-danger w-100">Revoke Permissions</button>
    @endif
</form>
