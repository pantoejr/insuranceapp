@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="card card-dark card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">{{ $title }}</div>
                        <div class="card-tools">
                            <a href="{{ route('email-settings.create') }}" class="btn btn-primary"><i
                                    class="bi bi-pencil-fill"></i>
                                Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dataTable nowrap">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Driver</td>
                                        <td>Host</td>
                                        <td>Action(s)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emailSettings as $emailSetting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $emailSetting->driver }}</td>
                                            <td>{{ $emailSetting->host }}</td>
                                            <td>
                                                <a href="{{ route('email-settings.edit', $emailSetting->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i>
                                                    Edit</a>
                                                <a href="{{ route('email-settings.details', $emailSetting->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-book-fill"></i>
                                                    Details</a>
                                                <a href="{{ route('email-settings.destroy', ['id' => $emailSetting->id]) }}"
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
