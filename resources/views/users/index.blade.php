@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title"><b>{{ $title }}</b></div>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->status == 'active')
                                                <span class="badge bg-success">{{ ucfirst($user->status) }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($user->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i
                                                    class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('users.details', $user->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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
