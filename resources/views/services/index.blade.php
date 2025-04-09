@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('services.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->cost }}</td>
                                        <td>
                                            @if ($service->status == 'active')
                                                <span class="badge bg-success">{{ ucfirst($service->status) }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($service->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-warning btn-sm"
                                                href="{{ route('services.edit', ['id' => $service->id]) }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('services.details', ['id' => $service->id]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-journal-text"></i>
                                            </a>
                                            <form action="{{ route('services.destroy', ['id' => $service->id]) }}"
                                                style="display: inline-block" method="POST">
                                                <button class="btn btn-danger btn-sm delete-btn"><i
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
