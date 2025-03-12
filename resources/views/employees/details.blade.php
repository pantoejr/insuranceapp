@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h4 class="mb-3">{{ $title }}</h4>
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 p-3">
                            @if ($employee->profile_picture)
                                <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Employee Photo"
                                    style="max-width: 20%;" class="rounded-circle">
                            @else
                                <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row p-3">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="client_id" class="form-label">Client</label>
                                        <input type="text" class="form-control" id="client_id"
                                            value="{{ $employee->client->full_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="employee_name" class="form-label">Employee Name</label>
                                        <input type="text" class="form-control" id="employee_name"
                                            value="{{ $employee->employee_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ $employee->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone"
                                            value="{{ $employee->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="position"
                                            value="{{ $employee->position }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input type="text" class="form-control" id="gender"
                                            value="{{ ucfirst($employee->gender) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status"
                                            value="{{ ucfirst($employee->status) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            value="{{ $employee->address }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth"
                                            value="{{ $employee->date_of_birth }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                        class="btn btn-light">Back
                                        to
                                        List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('employees.partials.employee_dependents', ['employee' => $employee])
@endsection
