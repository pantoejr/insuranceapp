@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Client Details</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="border p-3">
                                @if ($client->photo_picture)
                                    <img src="{{ asset('storage/' . $client->photo_picture) }}" alt="Client Photo"
                                        style="max-width: 70%;">
                                @else
                                    <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Client Type:</th>
                                    <td>{{ $client->client_type }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $client->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $client->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ ucfirst($client->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $client->address }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth:</th>
                                    <td>{{ $client->date_of_birth }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('clients.index') }}" class="btn btn-light">Back to List</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title" id="employee-header" style="cursor: pointer;">{{ $client->full_name }} Employees
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('employees.create', ['clientId' => $client->id]) }}" class="btn btn-primary">Add
                            Employee</a>
                    </div>
                </div>
                <div class="card-body" id="employee-body" style="display:none;">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Gender</td>
                                    <td>Position</td>
                                    <td>Email</td>
                                    <td>Action(s)</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->employee_name }}</td>
                                        <td>{{ ucfirst($employee->gender) }}</td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            <a href="{{ route('employees.edit', ['id' => $employee->id, 'clientId' => $client->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('employees.details', ['id' => $employee->id, 'clientId' => $client->id]) }}"
                                                class="btn btn-primary btn-sm"> Details</a>
                                            <form
                                                action="{{ route('employees.destroy', ['id' => $employee->id, 'clientId' => $client->id]) }}"
                                                method="POST" style="display:inline;">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title" id="attachment-header" style="cursor: pointer;">{{ $client->full_name }}
                        Attachments</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAttachmentModal">
                            Add Attachment
                        </button>
                        <div class="modal" id="addAttachmentModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Attachment</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="addAttachmentForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                            <div class="form-group mb-3">
                                                <label for="file_name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="file_name" name="file_name"
                                                    placeholder="Attachment Name" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="file_path" class="form-label">File</label>
                                                <input type="file" class="form-control" id="file_path" name="file_path"
                                                    required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <button type="submit" class="btn btn-success">Add Attachment</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <div id="loading" class="spinner-border text-primary" role="status"
                                                    style="display: none;">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="attachment-body" style="display:none;">
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
                                @foreach ($client->attachments as $attachment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td>{{ $attachment->file_type }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                                class="btn btn-info btn-sm"><i class="bi bi-down-arrow"></i>Download</a>
                                            <form
                                                action="{{ route('attachments.destroy', ['id' => $attachment->id, 'clientId' => $client->id]) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this attachment?')">Delete</button>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('#employee-header').click(function() {
                    $('#employee-body').toggle();
                });
                $('#attachment-header').click(function() {
                    $('#attachment-body').toggle();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#addAttachmentForm').on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $('#loading').show();

                    $.ajax({
                        url: '{{ route('clients.addAttachment', $client->id) }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#loading').hide();
                            if (response.flag === 'success') {
                                alert(response.msg);
                                location.reload();
                            } else {
                                alert(response.msg);
                            }
                        },
                        error: function(response) {
                            $('#loading').hide();
                            alert('An error occurred while adding the attachment.');
                        }
                    });
                });
            });
        </script>
    @endsection
