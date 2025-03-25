@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Clients</div>
                    <div class="card-tools">
                        <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle bold"></i>
                        </a>
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
                                            <a href="{{ route('clients.edit', $client->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('clients.details', $client->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                    <i class="bi bi-trash"></i></button>
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
