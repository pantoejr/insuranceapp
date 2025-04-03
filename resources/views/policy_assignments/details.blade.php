@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Policy Details <i><b>{{ $client->full_name }}</b></i></div>
                </div>
                <div class="card-body px-4">
                    <div class="row mb-3">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="insurer_id" class="form-label">Insurer</label>
                                <input type="text" class="form-control" name="insurer_id"
                                    value="{{ $policyAssignment->insurer->company_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="policy_id" class="form-label">Policy</label>
                                <input type="text" class="form-control" name="policy_id"
                                    value="{{ $policyAssignment->policy->name }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="policy_details" class="form-label">Policy Details</label>
                                <textarea name="policy_details" id="policy_details" readonly class="form-control" cols="30" rows="10">{{ $policyAssignment->policy->coverage_details }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="terms_conditions" class="form-label">Policy Terms</label>
                                <textarea name="terms_conditions" id="terms_conditions" readonly class="form-control" cols="30" rows="2">{{ $policyAssignment->policy->terms_conditions }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="cost" class="form-label">Cost</label>
                                        <input type="number" name="cost" id="cost" class="form-control" readonly
                                            value="{{ $policyAssignment->cost }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="currency" class="form-label">Currency</label>
                                        <input type="text" class="form-control" name="currency"
                                            value="{{ strtoupper($policyAssignment->currency) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                        <input type="text" name="payment_frequency" id="payment_frequency" readonly
                                            class="form-control"
                                            value="{{ ucfirst($policyAssignment->policy->premium_frequency) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <input type="text" class="form-control" name="payment_method"
                                            value="{{ ucfirst($policyAssignment->payment_method) }}" readonly>
                                    </div>
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

                    <div class="row">
                        <div class="col-md-6">
                            <form id="statusForm" style="display: inline-block"
                                action="{{ route('client-policies.setStatus', ['client' => $client->id, 'id' => $policyAssignment->id]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="status" id="status" value="">
                                <input type="text" name="id" value="{{ $policyAssignment->id }}" hidden>
                                @if ($policyAssignment->status === 'draft')
                                    <button type="button" id="confirmButton" class="btn btn-primary"><i
                                            class="bi bi-check-circle"></i>
                                        Confirm</button>
                                @elseif ($policyAssignment->status === 'submitted' || $policyAssignment->status === 'pending')
                                    <button type="button" id="approveButton" class="btn btn-success"><i
                                            class="bi bi-check-circle"></i>
                                        Approve</button>
                                    <button type="button" id="rejectButton" class="btn btn-danger"><i
                                            class="bi bi-x-circle"></i>
                                        Reject</button>
                                @elseif ($policyAssignment->status === 'approved')
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
@endsection
