@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h4 class="mb-3">{{ $title }}</h4>
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 p-3">
                            @if ($dependent->profile_picture)
                                <img src="{{ asset('storage/' . $dependent->profile_picture) }}" alt="Dependent Photo"
                                    style="max-width: 40%;" class="rounded">
                            @else
                                <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="employee_id" class="form-label">Employee</label>
                                        <input type="text" class="form-control" id="employee_id"
                                            value="{{ $dependent->employee->employee_name }} - ({{ $dependent->employee->client->full_name }})"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="dependent_name" class="form-label">Dependent Name</label>
                                        <input type="text" class="form-control" id="dependent_name"
                                            value="{{ $dependent->dependent_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input type="text" class="form-control" id="gender"
                                            value="{{ ucfirst($dependent->gender) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ $dependent->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone"
                                            value="{{ $dependent->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="relationship" class="form-label">Relationship</label>
                                        <input type="text" class="form-control" id="relationship"
                                            value="{{ $dependent->relationship }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status"
                                            value="{{ ucfirst($dependent->status) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            value="{{ $dependent->address }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth"
                                            value="{{ $dependent->date_of_birth }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="{{ route('employees.details', ['client' => $dependent->employee->client_id, 'employee' => $dependent->employee->id]) }}"
                                        class="btn btn-light">Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dependents.partials.dependent_attachments', ['dependent' => $dependent])
@endsection
