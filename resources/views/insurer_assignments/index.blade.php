@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header">
                    <div class="card-title">Insurer Assignments</div>
                    <div class="card-tools">
                        <a href="{{ route('insurer-assignments.create') }}" class="btn btn-primary">Add Insurer Assignment</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-{{ session('flag') }}">
                            {{ session('msg') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Insurer</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $assignment->insurer->company_name }}</td>
                                        <td>{{ $assignment->user->name }}</td>
                                        <td>{{ ucfirst($assignment->status) }}</td>
                                        <td>
                                            <a href="{{ route('insurer_assignments.details', $assignment->id) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('insurer_assignments.edit', $assignment->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-journal-text"></i></a>
                                            <form action="{{ route('insurer_assignments.destroy', $assignment->id) }}"
                                                method="POST" style="display:inline-block;">
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
