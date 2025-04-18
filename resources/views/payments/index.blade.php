@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-tools">
                        @can('add-payment')
                            <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i></a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Invoice No.</td>
                                    <td>Amount Paid</td>
                                    <td>Payment Date</td>
                                    <td>Payment Method</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->invoice_id }}</td>
                                        <td>{{ $payment->amount_paid }}</td>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $payment->status == 'rejected' ? 'danger' : ($payment->status == 'approved' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'primary')) }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @can('edit-payment')
                                                @if ($payment->status != 'approved')
                                                    <a href="{{ route('payments.edit', ['id' => $payment->id]) }}"
                                                        class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                                @endif
                                            @endcan
                                            @can('view-payment-details')
                                                <a href="{{ route('payments.details', ['id' => $payment->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-journal-text"></i></a>
                                            @endcan
                                            @can('delete-payment')
                                                <form action="{{ route('payments.destroy', ['id' => $payment->id]) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
                                                            class="bi bi-trash"></i></button>
                                                    @csrf
                                                </form>
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
