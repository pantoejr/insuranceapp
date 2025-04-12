@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('policy-types.create') }}" class="btn btn-primary"><i
                                class="bi bi-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($policyTypes as $policyType)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $policyType->name }}</td>
                                        <td>
                                            <a href="{{ route('policy-types.edit', ['id' => $policyType->id]) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('policy-types.show', ['id' => $policyType->id]) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            <form action="{{ route('policy-types.destroy', ['id' => $policyType->id]) }}"
                                                style="display: inline-block;" method="POST">
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
