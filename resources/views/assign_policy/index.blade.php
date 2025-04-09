@extends('layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    @can('add-client-policy')
                        <div class="card-tools">
                            <a href="{{ route('assign-policy.create') }}" class="btn btn-primary"><i
                                    class="bi bi-plus-circle"></i></a>
                        </div>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Policy</th>
                                    <th>Insurer</th>
                                    <th>Client</th>
                                    <th>Status</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignPolicies as $assignPolicy)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $assignPolicy->policy->name }}</td>
                                        <td>{{ $assignPolicy->insurer->company_name }}</td>
                                        <td>{{ $assignPolicy->client->full_name }}</td>
                                        <td>
                                            @if ($assignPolicy->status === 'draft')
                                                <span
                                                    class="badge bg-primary">{{ strtoupper($assignPolicy->status) }}</span>
                                            @elseif($assignPolicy->status === 'submitted')
                                                <span class="badge bg-info">{{ strtoupper($assignPolicy->status) }}</span>
                                            @elseif ($assignPolicy->status === 'pending')
                                                <span
                                                    class="badge bg-warning">{{ strtoupper($assignPolicy->status) }}</span>
                                            @elseif ($assignPolicy->status === 'approved')
                                                <span
                                                    class="badge bg-success">{{ strtoupper($assignPolicy->status) }}</span>
                                            @elseif ($assignPolicy->status === 'completed')
                                                <span
                                                    class="badge bg-success">{{ strtoupper($assignPolicy->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($assignPolicy->status === 'draft')
                                                @can('edit-client-policy')
                                                    <a href="{{ route('assign-policy.edit', ['id' => $assignPolicy->id]) }}"
                                                        class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                                @endcan
                                            @endif
                                            @can('view-client-policy-details')
                                                <a href="{{ route('assign-policy.details', ['id' => $assignPolicy->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-journal-text"></i></a>
                                            @endcan
                                            @can('delete-client-policy')
                                                <form
                                                    action="{{ route('assign-policy.destroy', ['id' => $assignPolicy->id]) }}"
                                                    style="display: inline-block" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
                                                            class="bi bi-trash"></i></button>
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
