@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Client Policy Details</div>
                    <div class="card-tools">
                        @if ($policyAssignment->status === 'draft')
                            <span class="badge bg-primary">{{ strtoupper($policyAssignment->status) }}</span>
                        @elseif($policyAssignment->status === 'submitted')
                            <span class="badge bg-info">{{ strtoupper($policyAssignment->status) }}</span>
                        @elseif ($policyAssignment->status === 'pending')
                            <span class="badge bg-warning">{{ strtoupper($policyAssignment->status) }}</span>
                        @elseif ($policyAssignment->status === 'approved')
                            <span class="badge bg-success">{{ strtoupper($policyAssignment->status) }}</span>
                        @elseif ($policyAssignment->status === 'completed')
                            <span class="badge bg-success">{{ strtoupper($policyAssignment->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body px-4">
                    <!-- Client, Insurer, and Policy Section -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client_id" class="form-label">Client</label>
                                <input type="text" class="form-control"
                                    value="{{ $policyAssignment->client->full_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="insurer_id" class="form-label">Insurer</label>
                                <input type="text" class="form-control"
                                    value="{{ $policyAssignment->insurer->company_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="policy_id" class="form-label">Policy</label>
                                <input type="text" class="form-control"
                                    value="{{ $policyAssignment->policy->policy_name }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="policy_details" class="form-label">Policy Details</label>
                                <input class="form-control" readonly value="{{ $policyAssignment->policy->description }}" />
                            </div>
                            <div class="form-group">
                                <label for="terms_conditions" class="form-label">Policy Terms</label>
                                <textarea class="form-control" rows="2" readonly>{{ $policyAssignment->policy->terms_conditions }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="cost" class="form-label">Cost</label>
                                        <input type="text" class="form-control"
                                            value="{{ $policyAssignment->cost }} {{ strtoupper($policyAssignment->currency) }}"
                                            readonly>
                                    </div>
                                </div>

                                <!-- Discount -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="discount" class="form-label">Discount</label>
                                        <input type="text" class="form-control"
                                            value="{{ $policyAssignment->discount }} ({{ $policyAssignment->discount_type }})"
                                            readonly>
                                    </div>
                                </div>

                                <!-- Payment Frequency -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($policyAssignment->policy->premium_frequency) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($policyAssignment->payment_method) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Uploaded Documents Section -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <p>Uploaded Documents</p>
                                @if ($policyAssignment->documents->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Document Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($policyAssignment->documents as $index => $document)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $document->document_name }}</td>
                                                        <td>{{ $document->document_type }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $document->document_path) }}"
                                                                target="_blank" class="btn btn-sm btn-primary">View</a>
                                                            <a href="{{ asset('storage/' . $document->document_path) }}"
                                                                download class="btn btn-sm btn-success">Download</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-danger">No documents uploaded.</p>
                                    <form
                                        action="{{ route('assign-policy.uploadDocuments', ['id' => $policyAssignment->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="inputGroupFile04"
                                                aria-describedby="inputGroupFileAddon04" required multiple
                                                aria-label="Upload">
                                            <button class="btn btn-outline-secondary" type="submit"
                                                id="inputGroupFileAddon04">Upload</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <form id="statusForm" style="display: inline-block"
                                action="{{ route('assign-policy.setStatus', ['id' => $policyAssignment->id]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="status" id="status" value="">
                                <input type="text" name="id" value="{{ $policyAssignment->id }}" hidden>
                                @if ($policyAssignment->status === 'draft')
                                    @can('submit-policy')
                                        <button type="button" id="confirmButton" class="btn btn-primary"><i
                                                class="bi bi-check-circle"></i>
                                            Confirm</button>
                                    @endcan
                                @elseif ($policyAssignment->status === 'submitted' || $policyAssignment->status === 'pending')
                                    @can('approve-policy')
                                        <button type="button" id="approveButton" class="btn btn-success"><i
                                                class="bi bi-check-circle"></i>
                                            Approve</button>
                                    @endcan
                                    @can('reject-policy')
                                        <button type="button" id="rejectButton" class="btn btn-danger"><i
                                                class="bi bi-x-circle"></i>
                                            Reject</button>
                                    @endcan
                                @elseif ($policyAssignment->status === 'approved')
                                    @can('complete-policy')
                                        <button type="button" id="completedButton" class="btn btn-success"><i
                                                class="bi bi-check-circle"></i>
                                            Mark As Done</button>
                                    @endcan
                                @endif
                            </form>
                            <a href="{{ route('assign-policy.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#confirmButton').on('click', function() {
                    $('#status').val('submitted');
                    $('#statusForm').submit();
                });

                $('#approveButton').on('click', function() {
                    $('#status').val('approved');
                    $('#statusForm').submit();
                });

                $('#rejectButton').on('click', function() {
                    $('#status').val('reject');
                    $('#statusForm').submit();
                });

                $('#completedButton').on('click', function() {
                    $('#status').val('completed');
                    $('#statusForm').submit();
                });
            });
        </script>
    @endsection
