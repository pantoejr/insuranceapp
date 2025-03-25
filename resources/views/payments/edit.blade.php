@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Edit Payment</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="invoice_id" class="form-label">Invoice ID</label>
                            <input type="text" name="invoice_id" id="invoice_id" class="form-control"
                                value="{{ $payment->invoice_id }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="amount_paid" class="form-label">Amount Paid</label>
                            <input type="text" name="amount_paid" id="amount_paid" class="form-control"
                                value="{{ $payment->amount_paid }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control"
                                value="{{ $payment->payment_date }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="usd" {{ $payment->currency == 'usd' ? 'selected' : '' }}>USD</option>
                                <option value="lrd" {{ $payment->currency == 'lrd' ? 'selected' : '' }}>LRD</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="cheque" {{ $payment->payment_method == 'cheque' ? 'selected' : '' }}>Cheque
                                </option>
                                <option value="bank transfer"
                                    {{ $payment->payment_method == 'bank transfer' ? 'selected' : '' }}>Bank Transfer
                                </option>
                                <option value="credit card"
                                    {{ $payment->payment_method == 'credit card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="debit card"
                                    {{ $payment->payment_method == 'debit card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="deferred" {{ $payment->payment_method == 'deferred' ? 'selected' : '' }}>
                                    Deferred</option>
                                <option value="mobile money"
                                    {{ $payment->payment_method == 'mobile money' ? 'selected' : '' }}>Mobile Money
                                </option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment_reference" class="form-label">Payment Reference</label>
                            <input type="text" name="payment_reference" id="payment_reference" class="form-control"
                                value="{{ $payment->payment_reference }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control">{{ $payment->notes }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="uploaded" {{ $payment->status == 'uploaded' ? 'selected' : '' }}>Uploaded
                                </option>
                                <option value="hold" {{ $payment->status == 'hold' ? 'selected' : '' }}>Hold</option>
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ $payment->status == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-light">Back To List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
