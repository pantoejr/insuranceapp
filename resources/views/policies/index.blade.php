@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <div class="card-title">Policies</div>
                    <div class="card-tools">
                        <a href="{{ route('policies.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Sub Type</th>
                                    <th>Number</th>
                                    <th>Premium Amount</th>
                                    <th>Currency</th>
                                    <th>Premium Frequency</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($policies as $policy)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $policy->policy_name }}</td>
                                        <td>{{ $policy->policyType->name }}</td>
                                        <td>{{ $policy->policySubType->name ?? 'N/A' }}</td>
                                        <td>{{ $policy->number }}</td>
                                        <td>{{ $policy->premium_amount }}</td>
                                        <td>{{ strtoupper($policy->currency) }}</td>
                                        <td>{{ ucfirst($policy->premium_frequency) }}</td>
                                        <td>
                                            <span
                                                class="p-1 btn btn-sm @if ($policy->status === 'active') btn-success
                                            @else btn-danger @endif">{{ ucfirst($policy->status) }}</span>
                                        </td>
                                        <td>

                                            <a href="{{ route('policies.edit', $policy->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('policies.details', $policy->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            <form action="{{ route('policies.destroy', $policy->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
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
