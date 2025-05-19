@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Policy Details for <strong>{{ $client->full_name }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="section-header bg-light p-2 mb-3 border-all">
                                        <i class="bi bi-file-earmark me-2"></i>Policy Information
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Insurer</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $policyAssignment->insurer->company_name ?? 'N/A' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Policy Type</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $policyAssignment->policyType->name ?? 'N/A' }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Policy Sub Type</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $policyAssignment->policySubType->name ?? 'N/A' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Premium Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="bi bi-currency-dollar"></i></span>
                                                    <input type="text" class="form-control"
                                                        value="{{ number_format($policyAssignment->cost, 2) }} {{ strtoupper($policyAssignment->currency) }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vehicle Information Section -->
                                    @if ($policyAssignment->policy->policyType->name === 'Motor Insurance' || $policyAssignment->policy->policyType->name === 'Auto Insurance')
                                        <div class="row mb-4">
                                            <h6 class="section-header bg-light p-2 mb-3 border-all">
                                                <i class="fas fa-car me-2"></i>Vehicle Information
                                            </h6>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Make & Model</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $policyAssignment->vehicle_make ?? 'N/A' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Year</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $policyAssignment->vehicle_year ?? 'N/A' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">VIN/Chassis Number</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $policyAssignment->vehicle_VIN ?? 'N/A' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Registration Number</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $policyAssignment->vehicle_reg_number ?? 'N/A' }}"
                                                        disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Vehicle Use Type</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ ucfirst($policyAssignment->vehicle_use_type) ?? 'N/A' }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <h6 class="section-header bg-light p-2 mb-3 border-all">
                                        <i class="fas fa-money-bill-wave me-2"></i>Payment Details
                                    </h6>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Currency</label>
                                        <input type="text" class="form-control"
                                            value="{{ strtoupper($policyAssignment->currency) }}" disabled>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Payment Frequency</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($policyAssignment->policy->premium_frequency) ?? 'N/A' }}"
                                            disabled>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Payment Method</label>
                                        <input type="text" class="form-control"
                                            value="{{ strtoupper($policyAssignment->payment_method) ?? 'N/A' }}" disabled>
                                    </div>

                                    @if ($policyAssignment->is_discounted)
                                        <div class="card border-0 shadow-sm mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Discount Applied</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Discount Type</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ ucfirst($policyAssignment->discount_type) ?? 'N/A' }}"
                                                        disabled>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Discount Value</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $policyAssignment->discount ?? '0' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <label class="form-label">Policy Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($policyAssignment->status) }}" disabled>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Policy Number</label>
                                        <input type="text" class="form-control"
                                            value="{{ $policyAssignment->policy->number ?? 'N/A' }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-primary">View</a>
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
                                            action="{{ route('client-policies.uploadDocuments', ['client' => $client->id, 'id' => $policyAssignment->id]) }}"
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
                        <div class="form-actions mt-4 border-top pt-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back
                                    </a>
                                </div>

                                <div>
                                    <form id="statusForm" style="display: inline-block"
                                        action="{{ route('client-policies.setStatus', ['client' => $client->id, 'id' => $policyAssignment->id]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="status" id="status" value="">
                                        <input type="text" name="id" value="{{ $policyAssignment->id }}" hidden>
                                        @if ($policyAssignment->status === 'draft')
                                            @can('submit-policy')
                                                <button type="button" id="confirmButton" class="btn btn-primary"><i
                                                    class="bi bi-check-circle"></i>
                                                Submit</button>
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
                                                <button type="button" id="completedButton" class="btn btn-success">
                                                    <i class="bi bi-check-circle"></i>
                                                    Complete
                                                </button>
                                            @endcan
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
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
                $('#status').val('rejected');
                $('#statusForm').submit();
            });

            $('#completedButton').on('click', function() {
                $('#status').val('completed');
                $('#statusForm').submit();
            });
        });
    </script>
@endsection
