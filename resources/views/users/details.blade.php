@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title"><b>{{ $title }}</b></div>
                </div>
                <div class="card-body">
                    <center><img id="photo-preview" src="{{ $user->photo ? asset('storage/' . $user->photo) : '#' }}"
                            alt="Photo Preview"
                            style="display: {{ $user->photo ? 'block' : 'none' }}; margin-top: 10px; max-height: 200px;">
                    </center>
                    <div class="row mb-1">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $user->name }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" value="{{ $user->phone }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="login_hint" class="form-label">Login Hint</label>
                                <input type="text" class="form-control" id="login_hint" value="{{ $user->login_hint }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status"
                                    value="{{ ucfirst($user->status) }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role"
                                    value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @can('refresh-user-permissions')
                            <div class="col">
                                <div class="form-group">
                                    <form action="{{ route('users.refreshPermissions', $user->id) }}"
                                        style="display: inline-block;" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Refresh Permissions</button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                        <div class="col">
                            <div class="form-group">
                                <a href="{{ route('users.index') }}" class="btn btn-light">Back to List</a>
                            </div>
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                        <div class="col"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
