@extends('layouts.app')
@section('content')
    <div class="row p-3">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="float-left">
                                @if ($payment->status === 'approved')
                                    <span class="badge bg-success">{{ ucfirst($payment->status) }}</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning">{{ ucfirst($payment->status) }}</span>
                                @else
                                    <span class="badge bg-primary p-2">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group float-end" role="group">
                                <a href="{{ route('payments.downloadReceipt', ['id' => $payment->id]) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-file-pdf"></i> Download Receipt</a>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#emailModal"><i class="bi bi-envelope-fill"></i> Email Receipt</button>
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
                            <h4>PAYMENT RECEIPT</h4>
                            <p>
                                <b>Date:</b> {{ date('Y-m-d', strtotime($payment->payment_date)) }}<br>
                                <b>Status:</b> {{ ucfirst($payment->status) }}
                            </p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p>
                                <b>{{ strtoupper($systemName) }}</b><br>
                                {{ $systemAddress }} <br>
                                {{ $systemEmail }} <br>
                                {{ $systemPhone }}
                            </p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <p>
                                <b>{{ $payment->invoice->client->full_name }}</b><br>
                                {{ $payment->invoice->client->address }}<br>
                                {{ $payment->invoice->client->phone }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Method</th>
                                            <th>Payment Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $payment->invoice_id }}</td>
                                            <td>{{ $payment->amount_paid }}</td>
                                            <td>{{ ucfirst($payment->payment_method) }}</td>
                                            <td>{{ $payment->payment_reference }}</td>
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
                                    value="{{ $payment->notes }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            @foreach (['approved', 'rejected'] as $status)
                                <form action="{{ route('payments.updateStatus', $payment->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit"
                                        class="btn btn-{{ $status == 'rejected' ? 'danger' : ($status == 'approved' ? 'success' : ($status == 'pending' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($status) }}
                                    </button>
                                </form>
                            @endforeach
                            <a href="{{ route('payments.index') }}" class="btn btn-light">Back To List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('payments.sendEmail', ['id' => $payment->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send Receipt via Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="to_email" class="form-label">To</label>
                                    <input type="email" name="to_email" id="to_email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="cc_email" class="form-label">CC</label>
                                    <input type="email" name="cc_email" id="cc_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bcc_email" class="form-label">BCC</label>
                                    <input type="email" name="bcc_email" id="bcc_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" id="body" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
