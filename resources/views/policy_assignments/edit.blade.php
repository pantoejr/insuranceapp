@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Edit Policy for <i><b>{{ $client->full_name }}</b></i></div>
                </div>
                <div class="card-body px-4">
                    <form
                        action="{{ route('client-policies.update', ['client' => $client, 'id' => $policyAssignment->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="insurer_id" class="form-label">Insurer</label>
                                    <select name="insurer_id" id="insurer_id"
                                        class="form-control @error('insurer_id') is-invalid @enderror">
                                        <option value="0">Select Insurer</option>
                                        @foreach ($insurers as $insurer)
                                            <option value="{{ $insurer->id }}"
                                                {{ $policyAssignment->insurer_id == $insurer->id ? 'selected' : '' }}>
                                                {{ $insurer->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="policy_id" class="form-label">Policy</label>
                                    <select name="policy_id" id="policy_id" class="form-control">
                                        <option value="0" selected>Select Policy</option>
                                        @foreach ($policies as $policy)
                                            <option value="{{ $policy->id }}"
                                                {{ $policyAssignment->policy_id == $policy->id ? 'selected' : '' }}>
                                                {{ $policy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="policy_details" class="form-label">Policy Details</label>
                                    <textarea name="policy_details" id="policy_details" class="form-control" cols="30" rows="10">{{ $policyAssignment->policy->coverage_details }}</textarea>
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
                                            <input type="number" name="cost" id="cost"
                                                class="form-control @error('cost') is-invalid @enderror"
                                                value="{{ $policyAssignment->cost }}">
                                            @error('cost')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="currency" class="form-label">Currency</label>
                                            <select name="currency" id="currency"
                                                class="form-control @error('currency') is-invalid @enderror">
                                                <option value="usd"
                                                    {{ $policyAssignment->currency == 'usd' ? 'selected' : '' }}>USD
                                                </option>
                                                <option value="lrd"
                                                    {{ $policyAssignment->currency == 'lrd' ? 'selected' : '' }}>LRD
                                                </option>
                                            </select>
                                            @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                            <input type="text" name="payment_frequency" id="payment_frequency" readonly
                                                class="form-control @error('payment_frequency') is-invalid @enderror"
                                                value="{{ $policyAssignment->policy->premium_frequency }}">
                                            @error('payment_frequency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select name="payment_method" id="payment_method"
                                                class="form-control @error('payment_method') is-invalid @enderror">
                                                <option value="Cash"
                                                    {{ $policyAssignment->payment_method == 'Cash' ? 'selected' : '' }}>
                                                    Cash</option>
                                                <option value="Cheque"
                                                    {{ $policyAssignment->payment_method == 'Cheque' ? 'selected' : '' }}>
                                                    Cheque</option>
                                                <option value="Bank Transfer"
                                                    {{ $policyAssignment->payment_method == 'Bank Transfer' ? 'selected' : '' }}>
                                                    Bank Transfer</option>
                                                <option value="Credit Card"
                                                    {{ $policyAssignment->payment_method == 'Credit Card' ? 'selected' : '' }}>
                                                    Credit Card</option>
                                                <option value="Debit Card"
                                                    {{ $policyAssignment->payment_method == 'Debit Card' ? 'selected' : '' }}>
                                                    Debit Card</option>
                                                <option value="Deferred"
                                                    {{ $policyAssignment->payment_method == 'Deferred' ? 'selected' : '' }}>
                                                    Deferred</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="document_path" class="form-label">Document</label>
                                            <input type="file" name="document_path[]" id="document_path"
                                                class="form-control" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                    class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
