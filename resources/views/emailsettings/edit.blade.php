@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('email-settings.update', $emailSetting->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="driver" class="form-label">Driver</label>
                                    <input type="text" class="form-control @error('driver') is-invalid @enderror"
                                        id="driver" value="{{ old('driver', $emailSetting->driver) }}"
                                        placeholder="Enter driver" required
                                        @error('driver') aria-describedby="driver-error" @enderror name="driver">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="host" class="form-label">Host</label>
                                    <input type="text" class="form-control @error('host') is-invalid @enderror"
                                        id="host" value="{{ old('host', $emailSetting->host) }}"
                                        placeholder="Enter host" required
                                        @error('host') aria-describedby="host-error" @enderror name="host">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="port" class="form-label">Port</label>
                                    <input type="number" class="form-control @error('port') is-invalid @enderror"
                                        id="port" value="{{ old('port', $emailSetting->port) }}"
                                        placeholder="Enter port" required
                                        @error('port') aria-describedby="port-error" @enderror name="port">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" value="{{ old('username', $emailSetting->username) }}"
                                        placeholder="Enter username" required
                                        @error('username') aria-describedby="username-error" @enderror name="username">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" value="{{ old('password', $emailSetting->password) }}"
                                        placeholder="Enter password" required
                                        @error('password') aria-describedby="password-error" @enderror name="password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="encryption" class="form-label">Encryption</label>
                                    <input type="text" class="form-control @error('encryption') is-invalid @enderror"
                                        id="encryption" value="{{ old('encryption', $emailSetting->encryption) }}"
                                        placeholder="Enter encryption" required
                                        @error('encryption') aria-describedby="encryption-error" @enderror
                                        name="encryption">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="from_address" class="form-label">From Address</label>
                                    <input type="email" class="form-control @error('from_address') is-invalid @enderror"
                                        id="from_address" value="{{ old('from_address', $emailSetting->from_address) }}"
                                        placeholder="Enter from address" required
                                        @error('from_address') aria-describedby="from_address-error" @enderror
                                        name="from_address">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="from_name" class="form-label">From Name</label>
                                    <input type="text" class="form-control @error('from_name') is-invalid @enderror"
                                        id="from_name" value="{{ old('from_name', $emailSetting->from_name) }}"
                                        placeholder="Enter from name" required
                                        @error('from_name') aria-describedby="from_name-error" @enderror name="from_name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="active"
                                            {{ old('status', $emailSetting->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $emailSetting->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Update</button>
                            <a href="{{ route('email-settings.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
