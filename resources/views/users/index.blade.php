@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-primary" wire:navigate><i
                                class="bi bi-pencil-fill"></i>
                            Add New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    @can('view-audit-log')
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                    @endcan
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->status) }}</td>
                                        @can('view-audit-log')
                                            <td>{{ $user->created_at }}</td>
                                            <td>{{ $user->updated_at }}</td>
                                            <td>{{ $user->created_by }}</td>
                                            <td>{{ $user->updated_by }}</td>
                                        @endcan
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"
                                                wire:navigate>Edit</a>
                                            <a href="{{ route('users.details', $user->id) }}"
                                                class="btn btn-primary btn-sm" wire:navigate>Details</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
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
