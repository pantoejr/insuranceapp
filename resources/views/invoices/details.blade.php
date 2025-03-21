@extends('layouts.app')
@section('content')
    <div class="row p-3">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                @if ($invoice->status === 'Paid')
                                    <span class="badge bg-success">{{ ucfirst($invoice->status) }}</span>
                                @elseif($invoice->status === 'partially-paid' || $invoice->status == 'Pending')
                                    <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                                @else
                                    <span class="badge bg-primary p-2">{{ ucfirst($invoice->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('invoices.download', ['id' => $invoice->invoice_id]) }}"
                                class="btn btn-primary btn-sm float-end"><i class="bi bi-file-pdf"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body py-4 px-5">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ asset('assets/images/VfPHgMS4ndKGxFSTrjGZDZqL5kpgXpnj2hTAZ8vn.png') }}"
                                alt="System Logo" width="200">
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <h4>INVOICE {{ $invoice->invoice_id }}</h4>
                            <p>
                                <b>Date:</b> {{ date('Y-m-d', strtotime($invoice->created_at)) }}<br>
                                <b>Due:</b> {{ date('Y-m-d', strtotime($invoice->due_date)) }}<br>
                                <b>Status:</b> {{ ucfirst($invoice->status) }}
                            </p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p>
                                <b>{{ strtoupper(env('APP_NAME')) }}</b><br>
                                2nd Street, Sinkor, Monrovia, Liberia<br>
                                +231 777 000 000
                            </p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <p>
                                <b>{{ $invoice->client->full_name }}</b><br>
                                {{ $invoice->client->address }}<br>
                                {{ $invoice->client->phone }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th>Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $invoice->policy->name . ' (' . $invoice->policy->number . ' )' }}</td>
                                            <td>{{ $invoice->policy->coverage_details }}</td>
                                            <td>{{ $invoice->total_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('invoices.updateStatus', ['id' => $invoice->invoice_id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ $invoice->notes }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Pending" {{ $invoice->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="partially-paid"
                                            {{ $invoice->status == 'partially-paid' ? 'selected' : '' }}>Partially Paid
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                                <a href="{{ route('invoices.sendEmail', ['id' => $invoice->invoice_id]) }}"
                                    class="btn btn-secondary">Send to
                                    Email</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
