@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('insurers.create') }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Add
                            New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>Status</td>
                                    <td>Action(s)</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurers as $insurer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a style="text-decoration: none;"
                                                href="{{ route('insurers.details', ['id' => $insurer->id]) }}">{{ $insurer->company_name }}</a>
                                        </td>
                                        <td>{{ $insurer->email }}</td>
                                        <td>{{ $insurer->phone }}</td>
                                        <td>{{ ucfirst($insurer->status) }}</td>
                                        <td>
                                            <a href="{{ route('insurers.edit', $insurer->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</a>
                                            <a href="{{ route('insurers.details', $insurer->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i> Details</a>
                                            <form action="{{ route('insurers.destroy', $insurer->id) }}" method="POST"
                                                style="display:inline;">
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
@endsection
