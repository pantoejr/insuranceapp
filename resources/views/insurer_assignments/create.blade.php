@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('insurer-assignments.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="insurer_id" class="form-label">Insurer</label>
                            <select class="form-control @error('insurer_id') is-invalid @enderror" id="insurer_id"
                                name="insurer_id" required>
                                @foreach ($insurers as $insurer)
                                    <option value="{{ $insurer->id }}"
                                        {{ old('insurer_id') == $insurer->id ? 'selected' : '' }}>
                                        {{ $insurer->company_name }}
                                    </option>
                                @endforeach
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
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{ route('insurer-assignments.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
