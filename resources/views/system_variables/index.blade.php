@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4" style="border:none;">
                    <div class="card-header" style="border:none;">
                        <div class="card-title">{{ $title }}</div>
                        <div class="card-tools">
                            <a href="{{ route('system-variables.create') }}" class="btn btn-primary "><i
                                    class="bi bi-plus-circle"></i>
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
                                        <td>Type</td>
                                        <td>Action(s)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($systemVariables as $variable)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $variable->name }}</td>
                                            <td>{{ $variable->type }}</td>
                                            <td>
                                                <a href="{{ route('system-variables.edit', $variable->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i>
                                                    Edit</a>
                                                <a href="{{ route('system-variables.details', $variable->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-book-fill"></i>
                                                    Details</a>
                                                <form
                                                    action="{{ route('system-variables.destroy', ['id' => $variable->id]) }}"
                                                    method="POST" style="display: inline-block">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
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
    </div>
@endsection
