@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        <a href="{{ route('policySubTypes.create') }}" class="btn btn-primary"><i
                                class="bi bi-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Policy Type</th>
                                    <th>Name</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($policySubTypes as $policySubType)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $policySubType->policyType->name }}</td>
                                        <td>{{ $policySubType->name }}</td>
                                        <td>
                                            <a href="{{ route('policySubTypes.edit', ['id' => $policySubType->id]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form
                                                action="{{ route('policySubTypes.destroy', ['id' => $policySubType->id]) }}"
                                                style="display: inline-block">
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
