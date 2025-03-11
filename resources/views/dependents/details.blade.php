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
                        <div class="col-lg-4">
                            <div class="border p-3">
                                @if ($dependent->profile_picture)
                                    <img src="{{ asset('storage/' . $dependent->profile_picture) }}" alt="Dependent Photo"
                                        style="max-width: 70%;">
                                @else
                                    <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Employee:</th>
                                    <td>{{ $dependent->employee->employee_name . ' (' . $dependent->employee->client->full_name . ')' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dependent Name:</th>
                                    <td>{{ $dependent->dependent_name }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ ucfirst($dependent->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $dependent->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $dependent->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Relationship:</th>
                                    <td>{{ $dependent->relationship }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ucfirst($dependent->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $dependent->date_of_birth }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        @if ($employeeId)
                            <a href="{{ route('employees.details', ['id' => $employeeId]) }}" class="btn btn-light">Back
                                to
                                List</a>
                        @else
                            <a href="{{ route('dependents.index') }}" class="btn btn-light">Back to List</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
