@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Attachments</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>File Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachments as $attachment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td>{{ $attachment->file_type }}</td>
                                        <td>
                                            <a href="{{ route('attachments.details', $attachment->id) }}"
                                                class="btn btn-primary btn-sm" download=""><i
                                                    class="bi bi-arrow-down"></i></a>
                                            <form action="{{ route('attachments.destroy', $attachment->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm delete-btn">
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
@endsection
