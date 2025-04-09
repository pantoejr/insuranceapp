@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        {{-- <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable table-striped nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    {{-- <td>Action(s)</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        {{-- <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</a>
                                            <a href="{{ route('permissions.destroy', ['id' => $permission->id]) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this permission?')"><i
                                                    class="bi bi-trash"></i>Delete</a>
                                        </td> --}}
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
