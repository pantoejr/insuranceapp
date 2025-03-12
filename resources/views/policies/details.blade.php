@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Policy Details</div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $policy->name }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" class="form-control" id="number" name="number"
                                value="{{ $policy->number }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" readonly>{{ $policy->description }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="coverage_details" class="form-label">Coverage Details</label>
                            <textarea class="form-control" id="coverage_details" name="coverage_details" readonly>{{ $policy->coverage_details }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="premium_amount" class="form-label">Premium Amount</label>
                            <input type="number" class="form-control" id="premium_amount" name="premium_amount"
                                value="{{ $policy->premium_amount }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="premium_frequency" class="form-label">Premium Frequency</label>
                            <input type="text" class="form-control" id="premium_frequency" name="premium_frequency"
                                value="{{ $policy->premium_frequency }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="policy_duration" class="form-label">Policy Duration</label>
                            <input type="text" class="form-control" id="policy_duration" name="policy_duration"
                                value="{{ $policy->policy_duration }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                            <textarea class="form-control" id="terms_conditions" name="terms_conditions" readonly>{{ $policy->terms_conditions }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="eligibility" class="form-label">Eligibility</label>
                            <textarea class="form-control" id="eligibility" name="eligibility" readonly>{{ $policy->eligibility }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                value="{{ ucfirst($policy->status) }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="created_by" class="form-label">Created By</label>
                            <input type="text" class="form-control" id="created_by" name="created_by"
                                value="{{ $policy->created_by }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="updated_by" class="form-label">Updated By</label>
                            <input type="text" class="form-control" id="updated_by" name="updated_by"
                                value="{{ $policy->updated_by }}" readonly>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('policies.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
