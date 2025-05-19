@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">Claim Details for <i><b>{{ $client->full_name }}</b></i></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="policy" class="form-label">Policy</label>
                                <input type="text" readonly class="form-control" value="{{ $claim->policy->policy_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" readonly class="form-control"
                                    value="{{ $claim->amount . ' ' . strtoupper($claim->currency) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="claim_type" class="form-label">Claim Type</label>
                                <input type="text" class="form-control" value="{{ $claim->claim_type }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" readonly value="{{ ucfirst($claim->status) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" readonly id="description" class="form-control" cols="30" rows="3">{{ $claim->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Claim Attachment(s)</h5>
                            @if ($claim->attachments->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped dataTable nowrap">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>File Name</td>
                                                <td>Actions(s)</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($claim->attachments as $attachment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attachment->file_name }}</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            target="_blank" class="btn btn-primary btn-sm"><i
                                                                class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            class="btn btn-success btn-sm" download>
                                                            <i class="bi bi-arrow-down"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No attachments available.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <form id="statusForm" style="display: inline-block"
                                action="{{ route('claims.setStatus', ['client' => $client->id, 'id' => $claim->id]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="status" id="status" value="">
                                <input type="text" name="id" value="{{ $claim->id }}" hidden>
                                @if ($claim->status === 'Pending Review')
                                    <button type="button" id="approveButton" class="btn btn-success"><i
                                            class="bi bi-check-circle"></i>
                                        Approve</button>
                                    <button type="button" id="rejectButton" class="btn btn-danger"><i
                                            class="bi bi-x-circle"></i>
                                        Reject</button>
                                @elseif ($claim->status === 'Approved')
                                    <button type="button" id="completedButton" class="btn btn-success"><i
                                            class="bi bi-check-circle"></i>
                                        Mark As Done</button>
                                @endif
                            </form>
                            <a href="{{ route('clients.details', ['id' => $client->id]) }}" class="btn btn-light">Back to
                                List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#approveButton').on('click', function() {
                $('#status').val('Approved');
                $('#statusForm').submit();
            });

            $('#rejectButton').on('click', function() {
                $('#status').val('Rejected');
                $('#statusForm').submit();
            });

            $('#completedButton').on('click', function() {
                $('#status').val('Processed');
                $('#statusForm').submit();
            });
        });
    </script>
@endsection
