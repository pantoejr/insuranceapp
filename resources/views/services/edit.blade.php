@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.update', $service->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $service->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="2"
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                    <textarea name="terms_conditions" id="terms_conditions" cols="30" rows="2"
                                        class="form-control @error('terms_conditions') is-invalid @enderror">{{ old('terms_conditions', $service->terms_conditions) }}</textarea>
                                    @error('terms_conditions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="eligibility" class="form-label">Eligibility</label>
                                    <select name="eligibility" id="eligibility"
                                        class="form-control @error('eligibility') is-invalid @enderror">
                                        <option value="individual"
                                            {{ old('eligibility', $service->eligibility) == 'individual' ? 'selected' : '' }}>
                                            Individual</option>
                                        <option value="company"
                                            {{ old('eligibility', $service->eligibility) == 'company' ? 'selected' : '' }}>
                                            Company</option>
                                        <option value="both"
                                            {{ old('eligibility', $service->eligibility) == 'both' ? 'selected' : '' }}>
                                            Both</option>
                                    </select>
                                    @error('eligibility')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="number" name="cost"
                                        class="form-control @error('cost') is-invalid @enderror"
                                        value="{{ old('cost', $service->cost) }}">
                                    @error('cost')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" id="currency"
                                        class="form-control @error('currency') is-invalid @enderror">
                                        <option value="usd"
                                            {{ old('currency', $service->currency) == 'usd' ? 'selected' : '' }}>USD
                                        </option>
                                        <option value="lrd"
                                            {{ old('currency', $service->currency) == 'lrd' ? 'selected' : '' }}>LRD
                                        </option>
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="frequency" class="form-label">Frequency</label>
                                    <select name="frequency" id="frequency"
                                        class="form-control @error('frequency') is-invalid @enderror">
                                        @foreach (['monthly', 'quartely', 'half-yearly', 'yearly', 'bi-yearly', 'tri-yearly', 'four-yearly', 'five-yearly'] as $frequency)
                                            <option value="{{ $frequency }}"
                                                {{ old('frequency', $service->frequency) == $frequency ? 'selected' : '' }}>
                                                {{ ucfirst($frequency) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('frequency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="active"
                                            {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('services.index') }}" class="btn btn-light">Back to List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
