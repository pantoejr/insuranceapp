<div class="modal" wire:ignore.self id="addUserModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Add User Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Add User Modal Modal Body -->
            <div class="modal-body">
                <form wire:submit.prevent="addUser" id="addUserForm" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="insurer_id" class="form-label">Insurer</label>
                        <input type="text" value="{{ $insurer->company_name }}" class="form-control" readonly>
                        <input type="hidden" wire:model="insurer_id" value="{{ $insurer->id }}">
                        @error('insurer_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select wire:model="user_id" class="form-control">
                            <option value="0">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
