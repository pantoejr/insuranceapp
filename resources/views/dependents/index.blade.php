@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Dependents</div>
                    <div class="card-tools">
                        <a href="{{ route('dependents.create') }}" class="btn btn-primary">Add Dependent</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Relationship</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dependents as $dependent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a style="text-decoration: none;"
                                                href="{{ route('dependents.details', ['id' => $dependent->id]) }}">{{ $dependent->dependent_name }}</a>
                                        </td>
                                        <td>{{ $dependent->email }}</td>
                                        <td>{{ $dependent->phone }}</td>
                                        <td>{{ $dependent->relationship }}</td>
                                        <td>
                                            <a href="{{ route('dependents.edit', $dependent->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('dependents.details', $dependent->id) }}"
                                                class="btn btn-info btn-sm">Details</a>
                                            <form action="{{ route('dependents.destroy', $dependent->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this dependent?')">Delete</button>
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
