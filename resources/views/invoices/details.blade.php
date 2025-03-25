@extends('layouts.app')
@section('content')
    <div class="row p-3">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="float-left">
                                @if ($invoice->status === 'Paid')
                                    <span class="badge bg-success">{{ ucfirst($invoice->status) }}</span>
                                @elseif($invoice->status === 'partially-paid' || $invoice->status == 'Pending')
                                    <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                                @else
                                    <span class="badge bg-primary p-2">{{ ucfirst($invoice->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group float-end" role="group">
                                @if ($invoice->status !== 'Paid')
                                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#paymentModal">
                                        <i class="bi bi-currency-dollar"></i> Payment
                                    </a>
                                @endif
                                <a href="{{ route('invoices.sendEmail', ['id' => $invoice->invoice_id]) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-envelope-fill"></i> Mail</a>
                                <a href="{{ route('invoices.download', ['id' => $invoice->invoice_id]) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-file-pdf"></i> Download</a>
                            </div>
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
                                @if ($invoice->due_date >= date('Y'))
                                    <b>Due:</b> {{ date('Y-m-d', strtotime($invoice->due_date)) }}<br>
                                @else
                                    <b>Due:</b> No date set<br>
                                @endif

                                <b>Status:</b>
                                <span
                                    class="@if ($invoice->status === 'Draft') text-primary
                                @elseif($invoice->status === 'Paid')
                                text-success
                                @elseif ($invoice->status === 'Partially-Paid' || $invoice->status === 'Pending')
                                text-warning
                                @else
                                text-danger @endif">{{ ucfirst($invoice->status) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p>
                                <b>{{ strtoupper($systemName->value) }}</b><br>
                                {{ $systemAddress->value }} <br>
                                {{ $systemEmail->value }} <br>
                                {{ $systemPhone->value }}
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
                                            <td>{{ $invoice->policy->description }}</td>
                                            <td>{{ $invoice->total_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Coverage</th>
                                            <td colspan="2">{{ $invoice->policy->coverage_details }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td>{{ $invoice->total_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <input type="text" name="notes" id="notes" readonly class="form-control"
                                    value="{{ $invoice->notes }}" />
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <a href="{{ route('invoices.index') }}" class="btn btn-light">Back To List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-lg fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Record Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="invoice_id" class="form-label">Invoice ID</label>
                            <input type="text" name="invoice_id" id="invoice_id" class="form-control"
                                value="{{ $invoice->invoice_id }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="amount_paid" class="form-label">Amount Receive</label>
                            <input type="text" name="amount_paid" id="amount_paid" class="form-control"
                                value="{{ $invoice->balance }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="bank transfer">Bank Transfer</option>
                                <option value="credit card">Credit Card</option>
                                <option value="debit card">Debit Card</option>
                                <option value="deferred">Deferred</option>
                                <option value="mobile money">Mobile Money</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_reference" class="form-label">Payment Reference</label>
                            <input type="text" name="payment_reference" id="payment_reference" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
