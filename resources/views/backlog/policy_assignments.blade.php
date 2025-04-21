@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        @can('add-backlog-policy-assignment')
                            <a href="{{ route('backlog.addPolicyAssignment') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Policy</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Start</th>
                                    <th scope="col">End</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($policyAssignments as $policyAssignment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $policyAssignment->policy->policy_name }}</td>
                                        <td>{{ $policyAssignment->client->full_name }}</td>
                                        <td>{{ $policyAssignment->policy_duration_start }}</td>
                                        <td>{{ $policyAssignment->policy_duration_end }}</td>
                                        <td>
                                            @can('edit-backlog-policy-assignment')
                                                <a href="{{ route('backlog.editPolicyAssignment', ['id' => $policyAssignment->id]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                            @endcan
                                            @can('view-backlog-policy-assignment')
                                                <a href="{{ route('backlog.policyAssignmentDetails', ['id' => $policyAssignment->id]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            @endcan
                                            @can('delete-backlog-policy-assignment')
                                                <form
                                                    action="{{ route('backlog.policyAssignmentDestroy', ['id' => $policyAssignment->id]) }}"
                                                    method="POST" style="display: inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
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
@endsection
