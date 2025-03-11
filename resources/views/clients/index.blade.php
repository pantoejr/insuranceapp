@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Clients</div>
                    <div class="card-tools">
                        <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="bi bi-pencil-fill"></i> Add
                            New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
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
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i> Edit</a>
                                            <a href="{{ route('clients.details', $client->id) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Details</a>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
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
