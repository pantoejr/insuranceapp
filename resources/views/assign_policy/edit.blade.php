@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Edit Client Policy</div>
                    <div class="card-tools">
                        @if ($assignPolicy->status === 'draft')
                            <span class="badge bg-primary">{{ strtoupper($assignPolicy->status) }}</span>
                        @elseif($assignPolicy->status === 'submitted')
                            <span class="badge bg-info">{{ strtoupper($assignPolicy->status) }}</span>
                        @elseif ($assignPolicy->status === 'pending')
                            <span class="badge bg-warning">{{ strtoupper($assignPolicy->status) }}</span>
                        @elseif ($assignPolicy->status === 'approved')
                            <span class="badge bg-success">{{ strtoupper($assignPolicy->status) }}</span>
                        @elseif ($assignPolicy->status === 'completed')
                            <span class="badge bg-success">{{ strtoupper($assignPolicy->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body px-4">
                    <!-- Client, Insurer, and Policy Section -->
                    <form action="{{ route('assign-policy.update', ['id' => $assignPolicy->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_id" class="form-label">Client</label>
                                    <input type="text" class="form-control"
                                        value="{{ $assignPolicy->client->full_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="insurer_id" class="form-label">Insurer</label>
                                    <input type="text" class="form-control"
                                        value="{{ $assignPolicy->insurer->company_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="policy_id" class="form-label">Policy</label>
                                    <input type="text" class="form-control" value="{{ $assignPolicy->policy->name }}"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="policy_details" class="form-label">Policy Details</label>
                                    <textarea class="form-control" rows="10" readonly>{{ $assignPolicy->policy->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="terms_conditions" class="form-label">Policy Terms</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $assignPolicy->policy->terms_conditions }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="cost" class="form-label">Cost</label>
                                            <input type="text" class="form-control" name="cost"
                                                value="{{ $assignPolicy->cost }}">
                                        </div>
                                    </div>

                                    <!-- Discount -->
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="discount" class="form-label">Discount</label>
                                            <input type="text" class="form-control" name="discount"
                                                value="{{ $assignPolicy->discount }}">
                                        </div>
                                    </div>

                                    <!-- Payment Frequency -->
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                            <input type="text" class="form-control" name="payment_frequency"
                                                value="{{ ucfirst($assignPolicy->policy->premium_frequency) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <input type="text" class="form-control" name="payment_method"
                                                value="{{ ucfirst($assignPolicy->payment_method) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Uploaded Documents Section -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <p>Uploaded Documents</p>
                                    @if ($assignPolicy->documents->count() > 0)
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
                                                    @foreach ($assignPolicy->documents as $index => $document)
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
                                            action="{{ route('assign-policy.uploadDocuments', ['id' => $assignPolicy->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile04"
                                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
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
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('assign-policy.index') }}" class="btn btn-light">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
