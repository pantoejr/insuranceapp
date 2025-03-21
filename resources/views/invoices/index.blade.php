@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Invoice No.</td>
                                    <td>Status</td>
                                    <td>Due</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('invoices.details', ['id' => $invoice->invoice_id]) }}"
                                                class="text-decoration-none">
                                                {{ $invoice->invoice_id }}
                                            </a>
                                        </td>
                                        <td>{{ ucfirst($invoice->status) }}</td>
                                        <td>{{ ucfirst($invoice->due_date) }}</td>
                                        <td>
                                            <a href="{{ route('invoices.edit', ['id' => $invoice->invoice_id]) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="{{ route('invoices.details', ['id' => $invoice->invoice_id]) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-journal-text"></i></a>
                                            <a href="{{ route('invoices.destroy', ['id' => $invoice->invoice_id]) }}"
                                                class="btn btn-danger btn-sm" onclick="confirmDelete(event)"><i
                                                    class="bi bi-trash"></i></a>
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
