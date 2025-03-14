@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Edit Insurer Assignment</div>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('insurer-assignments.update', ['insurer' => $insurer, 'insurerAssignment' => $assignment]) }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="insurer_id" class="form-label">Insurer</label>
                            <select class="form-control @error('insurer_id') is-invalid @enderror" id="insurer_id"
                                name="insurer_id" required>
                                <option value="{{ $insurer->id }}"
                                    {{ old('insurer_id', $assignment->insurer_id) == $insurer->id ? 'selected' : '' }}>
                                    {{ $insurer->company_name }}
                                </option>
                            </select>
                            @error('insurer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $assignment->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active"
                                    {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive"
                                    {{ old('status', $assignment->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('insurers.details', ['id' => $insurer->id]) }}" class="btn btn-light">Back
                                to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
