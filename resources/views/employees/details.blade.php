@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="border p-3">
                                @if ($employee->profile_picture)
                                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Client Photo"
                                        style="max-width: 70%;">
                                @else
                                    <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Client:</th>
                                    <td>{{ $employee->client->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $employee->employee_name }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ ucfirst($employee->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Position:</th>
                                    <td>{{ $employee->position }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $employee->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ ucfirst($employee->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $employee->address }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth:</th>
                                    <td>{{ $employee->date_of_birth }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if ($clientId)
                        <a href="{{ route('clients.details', ['id' => $clientId]) }}" class="btn btn-light">Back to
                            List</a>
                    @else
                        <a href="{{ route('employees.index') }}" class="btn btn-light">Back to List</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header" id="dependents-header" style="cursor:pointer;" title="Click to show">
                    <div class="card-title">{{ $employee->employee_name }} Dependents</div>
                    <div class="card-tools">
                        <a href="{{ route('dependents.create', ['employeeId' => $employee->id, 'clientId' => $clientId]) }}"
                            class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Add
                            Dependent</a>
                    </div>
                </div>
                <div class="card-body" id="dependents-body" style="display:none;">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Gender</td>
                                    <td>Date of Birth</td>
                                    <td>Action(s)</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->dependents as $dependent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dependent->dependent_name }}</td>
                                        <td>{{ ucfirst($dependent->gender) }}</td>
                                        <td>{{ $dependent->date_of_birth }}</td>
                                        <td>
                                            <a href="{{ route('dependents.edit', ['id' => $dependent->id, 'employeeId' => $employee->id, 'clientId' => $clientId]) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                            <a href="{{ route('dependents.details', ['id' => $dependent->id, 'employeeId' => $employee->id, 'clientId' => $clientId]) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-book"></i> Details</a>
                                            <form
                                                action="{{ route('dependents.destroy', ['id' => $dependent->id, 'employeeId' => $employee->id, 'clientId' => $clientId]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this client?');"><i
                                                        class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dependents-header').click(function() {
                $('#dependents-body').toggle();
            });
            $('#claim-header').click(function() {
                $('#claim-body').toggle();
            });
        });
    </script>
@endsection
