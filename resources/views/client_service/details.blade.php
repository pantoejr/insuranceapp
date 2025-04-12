@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="service_id" class="form-label">Service</label>
                                <input type="text" readonly value="{{ $clientService->service->name }}"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="client_id" class="form-label">Client</label>
                                <input type="text" readonly value="{{ $clientService->client->name }}"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="cost" class="form-label">Cost</label>
                                <input type="text" id="cost" readonly class="form-control"
                                    value="{{ $clientService->cost }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <input type="text" readonly value="{{ strtoupper($clientService->currency) }}"
                                    name="currency" id="currency" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="is_discounted" class="form-label">Is Discounted?</label>
                                <input type="text" readonly value="{{ $clientService->is_discounted ? 'Yes' : 'No' }}"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    @if ($clientService->is_discounted)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <input type="text" readonly value="{{ ucfirst($clientService->discount_type) }}"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="text" readonly value="{{ $clientService->discount }}"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea readonly class="form-control" rows="3">{{ $clientService->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="service_duration_start" class="form-label">Service Start Date</label>
                                <input type="text" readonly value="{{ $clientService->service_duration_start }}"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="service_duration_end" class="form-label">Service End Date</label>
                                <input type="text" readonly value="{{ $clientService->service_duration_end }}"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <input type="text" readonly value="{{ ucfirst($clientService->payment_method) }}"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" readonly value="{{ $clientService->status }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                    @if ($clientService->attachments->count() > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="attachments" class="form-label">Attachments</label>
                                    <table class="table table-bordered table-striped dataTable nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>File Type</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clientService->attachments as $index => $attachment)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $attachment->file_name }}</td>
                                                    <td>{{ $attachment->file_type }}</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            class="btn btn-primary btn-sm" download>
                                                            Download
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($clientService->status === 'Pending')
                        <form
                            action="{{ route('client-service.update-status', ['client' => $client, 'id' => $clientService->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <button type="submit" name="status" value="Completed"
                                            class="btn btn-success">Mark
                                            as Completed</button>
                                        <button type="submit" name="status" value="Rejected"
                                            class="btn btn-danger">Mark
                                            as Rejected</button>
                                        <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                            class="btn btn-light">Back to List</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($clientService->status === 'Completed')
                        <p class="text-success">This service has already been marked as Completed.</p>
                    @elseif($clientService->status === 'Rejected')
                        <p class="text-danger">This service has been Rejected.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
