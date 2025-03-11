@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="driver" class="form-label">Driver</label>
                                <input type="text" class="form-control" id="driver"
                                    value="{{ $emailSetting->driver }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="host" class="form-label">Host</label>
                                <input type="text" class="form-control" id="host" value="{{ $emailSetting->host }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="port" class="form-label">Port</label>
                                <input type="number" class="form-control" id="port" value="{{ $emailSetting->port }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username"
                                    value="{{ $emailSetting->username }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password"
                                    value="{{ $emailSetting->password }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="encryption" class="form-label">Encryption</label>
                                <input type="text" class="form-control" id="encryption"
                                    value="{{ $emailSetting->encryption }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="from_address" class="form-label">From Address</label>
                                <input type="email" class="form-control" id="from_address"
                                    value="{{ $emailSetting->from_address }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="from_name" class="form-label">From Name</label>
                                <input type="text" class="form-control" id="from_name"
                                    value="{{ $emailSetting->from_name }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status"
                                    value="{{ ucfirst($emailSetting->status) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('email-settings.index') }}" class="btn btn-light">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
