@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4" style="border:none;">
                    <div class="card-header" style="border:none;">
                        <div class="card-title">{{ $title }}</div>
                        <div class="card-tools">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary "><i class="bi bi-plus-circle"></i>
                                Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table dataTable nowrap">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Action(s)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i>
                                                    Edit</a>
                                                <a href="{{ route('roles.details', $role->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-book-fill"></i>
                                                    Details</a>
                                                <a href="{{ route('roles.destroy', ['id' => $role->id]) }}"
                                                    class="btn btn-danger btn-sm" onclick="confirmDelete(event)"><i
                                                        class="bi bi-trash"></i>Delete</a>
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
    </div>
@endsection
