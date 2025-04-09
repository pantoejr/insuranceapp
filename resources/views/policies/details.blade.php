@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 mb-4 shadow-sm">
                <div class="card-header">
                    <div class="card-title">Policy Details</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="policy_type" class="form-label">Policy Type</label>
                                <input type="text" class="form-control" id="policy_type" name="policy_type"
                                    value="{{ $policy->policyType->name }}" disabled>
                            </div>
                        </div>
                        @if ($policy->policySubType)
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="policy_sub_type" class="form-label">Policy Sub Type</label>
                                    <input type="text" class="form-control" id="policy_sub_type" name="policy_sub_type"
                                        value="{{ $policy->policySubType->name }}" disabled>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" class="form-control" id="number" name="number"
                                    value="{{ $policy->number }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" disabled>{{ $policy->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="coverage_details" class="form-label">Coverage Details</label>
                                <textarea class="form-control" id="coverage_details" name="coverage_details" disabled>{{ $policy->coverage_details }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="premium_amount" class="form-label">Premium Amount</label>
                                <input type="number" class="form-control" id="premium_amount" name="premium_amount"
                                    value="{{ $policy->premium_amount }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="premium_frequency" class="form-label">Premium Frequency</label>
                                <input type="text" class="form-control" id="premium_frequency" name="premium_frequency"
                                    value="{{ ucfirst($policy->premium_frequency) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <input type="text" class="form-control" id="currency" name="currency"
                                    value="{{ strtoupper($policy->currency) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                <textarea class="form-control" id="terms_conditions" name="terms_conditions" disabled>{{ $policy->terms_conditions }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="eligibility" class="form-label">Eligibility</label>
                                <input type="text" class="form-control" id="eligibility" name="eligibility" disabled
                                    value="{{ strtoupper($policy->eligibility) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ ucfirst($policy->status) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('policies.index') }}" class="btn btn-light">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('policies.partials.insurer_policies')
@endsection
