@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Insurer Policies</div>
                    <div class="card-tools">
                        <a href="{{ route('insurer-policies.create') }}" class="btn btn-primary">Add Insurer Policy</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Insurer</th>
                                    <th>Policy</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurerPolicies as $insurerPolicy)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $insurerPolicy->insurer->company_name }}</td>
                                        <td>{{ $insurerPolicy->policy->name }}</td>
                                        <td>{{ ucfirst($insurerPolicy->status) }}</td>
                                        <td>
                                            <a href="{{ route('insurer-policies.edit', $insurerPolicy->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('insurer-policies.destroy', $insurerPolicy->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this insurer policy?')">Delete</button>
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
