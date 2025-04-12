@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header">
                    <div class="card-title">Clients</div>
                    <div class="card-tools">
                        @can('add-client')
                            <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle bold"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Client Type</td>
                                    <td>Full Name</td>
                                    <td>Status</td>
                                    <td>Action(s)</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $client->client_type }}</td>
                                        <td><a style="text-decoration: none;"
                                                href="{{ route('clients.details', ['id' => $client->id]) }}">{{ $client->full_name }}</a>
                                        </td>
                                        <td>{{ ucfirst($client->status) }}</td>
                                        <td>
                                            @can('edit-client')
                                                <a href="{{ route('clients.edit', $client->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            @endcan
                                            @can('view-client-details')
                                                <a href="{{ route('clients.details', $client->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            @endcan
                                            @can('delete-client')
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i></button>
                                                </form>
                                            @endcan
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
