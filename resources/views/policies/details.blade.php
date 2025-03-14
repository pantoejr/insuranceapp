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
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $policy->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" class="form-control" id="number" name="number"
                                    value="{{ $policy->number }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" readonly>{{ $policy->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="coverage_details" class="form-label">Coverage Details</label>
                                <textarea class="form-control" id="coverage_details" name="coverage_details" readonly>{{ $policy->coverage_details }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="premium_amount" class="form-label">Premium Amount</label>
                                <input type="number" class="form-control" id="premium_amount" name="premium_amount"
                                    value="{{ $policy->premium_amount }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="premium_frequency" class="form-label">Premium Frequency</label>
                                <input type="text" class="form-control" id="premium_frequency" name="premium_frequency"
                                    value="{{ ucfirst($policy->premium_frequency) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="policy_duration" class="form-label">Policy Duration</label>
                                <input type="text" class="form-control" id="policy_duration" name="policy_duration"
                                    value="{{ $policy->policy_duration }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                <textarea class="form-control" id="terms_conditions" name="terms_conditions" readonly>{{ $policy->terms_conditions }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="eligibility" class="form-label">Eligibility</label>
                                <input type="text" class="form-control" id="eligibility" name="eligibility" readonly
                                    value="{{ $policy->eligibility }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ ucfirst($policy->status) }}" readonly>
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
