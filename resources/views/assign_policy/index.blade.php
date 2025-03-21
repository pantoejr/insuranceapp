@extends('layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('assign-policy.create') }}" class="btn btn-primary"><i
                                class="bi bi-plus-circle"></i></a>
                    </div>
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
                                                <span class="badge bg-primary">{{ $assignPolicy->status }}</span>
                                            @elseif($assignPolicy->status === 'submitted')
                                                <span class="badge bg-info">{{ $assignPolicy->status }}</span>
                                            @elseif ($assignPolicy->status === 'pending')
                                                <span class="badge bg-warning">{{ $assignPolicy->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('assign-policy.edit', ['id' => $assignPolicy->id]) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('assign-policy.details', ['id' => $assignPolicy->id]) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-journal-text"></i></a>
                                            <form
                                                action="{{ route('assign-policy.destroy', ['id' => $assignPolicy->id]) }}"
                                                style="display: inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this client policy?')"><i
                                                        class="bi bi-trash"></i></button>
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
@endsection
