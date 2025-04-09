<form wire:submit.prevent="submit">
    @csrf
    <div class="card card-success card-outline mb-4">
        <div class="card-header">
            <div class="card-title">Add Permissions for {{ $role->name }}</div>
        </div>
        <div class="card-body" style="overflow: auto; height: 300px;">
            @if (empty($availablePermissions))
                <p>No permissions available to assign. This role may already have all permissions.</p>
            @else
                @foreach ($availablePermissions as $permissionId => $permissionName)
                    <div class="form-group">
                        <input wire:model="selectedPermissions" type="checkbox" value="{{ $permissionName }}"
                            id="{{ $permissionName }}" />
                        <label for="{{ $permissionName }}">{{ $permissionName }}</label>
                    </div>
                    <hr>
                @endforeach
            @endif

        </div>
    </div>
    @if (!empty($availablePermissions))
        <button type="submit" class="btn btn-success w-100">Assign Permissions</button>
    @endif
</form>
