@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <div class="card-title">Create Policy</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('policies.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ old('number') }}" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="coverage_details" class="form-label">Coverage Details</label>
                            <textarea class="form-control @error('coverage_details') is-invalid @enderror" id="coverage_details"
                                name="coverage_details">{{ old('coverage_details') }}</textarea>
                            @error('coverage_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="premium_amount" class="form-label">Premium Amount</label>
                            <input type="number" class="form-control @error('premium_amount') is-invalid @enderror"
                                id="premium_amount" name="premium_amount" value="{{ old('premium_amount') }}" required>
                            @error('premium_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="premium_frequency" class="form-label">Premium Frequency</label>
                            <select class="form-control @error('premium_frequency') is-invalid @enderror"
                                id="premium_frequency" name="premium_frequency" required>
                                <option value="monthly" {{ old('premium_frequency') == 'monthly' ? 'selected' : '' }}>
                                    Monthly</option>
                                <option value="quarterly" {{ old('premium_frequency') == 'quarterly' ? 'selected' : '' }}>
                                    Quarterly</option>
                                <option value="half-yearly"
                                    {{ old('premium_frequency') == 'half-yearly' ? 'selected' : '' }}>Half-Yearly</option>
                                <option value="yearly" {{ old('premium_frequency') == 'yearly' ? 'selected' : '' }}>Yearly
                                </option>
                            </select>
                            @error('premium_frequency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="policy_duration" class="form-label">Policy Duration</label>
                            <input type="number" class="form-control @error('policy_duration') is-invalid @enderror"
                                id="policy_duration" name="policy_duration" value="{{ old('policy_duration') }}" required>
                            @error('policy_duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                            <textarea class="form-control @error('terms_conditions') is-invalid @enderror" id="terms_conditions"
                                name="terms_conditions">{{ old('terms_conditions') }}</textarea>
                            @error('terms_conditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="eligibility" class="form-label">Eligibility</label>
                            <select class="form-control @error('eligibility') is-invalid @enderror" id="eligibility"
                                name="eligibility" required>
                                <option value="Individual" {{ old('eligibility') == 'Individual' ? 'selected' : '' }}>
                                    Individual</option>
                                <option value="Company" {{ old('eligibility') == 'Company' ? 'selected' : '' }}>Company
                                </option>
                                <option value="Both" {{ old('eligibility') == 'Both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('eligibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{ route('policies.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
