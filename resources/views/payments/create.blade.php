@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form id="paymentForm" method="POST" action="{{ route('payments.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    </div>
                                    <input type="text"
                                        class="form-control @error('invoice_id')
                                        is-invalid
                                    @enderror"
                                        name="invoice_id" id="invoice_id" aria-describedby="invoice_id">
                                </div>
                                <p class="text-danger" id="invoiceError" style="display: none;">No Invoice Exists with
                                    such ID</p>
                            </div>
                        </div>

                        <div id="additionalFields" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="amount_paid" class="form-label">Amount Received <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('amount_paid')
                                        is_invalid
                                        @enderror"
                                            id="amount_paid" name="amount_paid">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_date" class="form-label">Payment Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('payment_date')
                                            is-invalid
                                        @enderror"
                                            id="payment_date" name="payment_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_method" class="form-label">Payment Method <span
                                                class="text-danger">*</span></label>
                                        <select name="payment_method" id="payment_method"
                                            class="form-control @error('payment_method')
                                            is-invalid
                                        @enderror">
                                            <option value="0">Select Payment Method</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bank transfer">Bank Transfer</option>
                                            <option value="credit card">Credit Card</option>
                                            <option value="debit card">Debit Card</option>
                                            <option value="deferred">Deferred</option>
                                            <option value="mobile money">Mobile Money</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reference_number" class="form-label">Reference Number</label>
                                        <input type="text" class="form-control" id="reference_number"
                                            name="reference_number">
                                    </div>
                                </div>
                            </div>
                            <div class=" mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ route('payments.index') }}" class="btn btn-light">Back To List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#invoice_id').on('blur', function() {
                var invoiceId = $(this).val();
                if (invoiceId) {
                    $.ajax({
                        url: `/invoices/checkInvoice/${invoiceId}`,
                        method: 'GET',
                        success: function(response) {
                            if (response) {
                                $('#amount_paid').val(response.balance)
                                $('#additionalFields').show();
                                $('#invoiceError').hide();
                            } else {
                                $('#additionalFields').hide();
                                $('#invoiceError').show();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
