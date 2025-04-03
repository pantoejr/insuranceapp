@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" value="{{ $service->name }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost" class="form-label">Cost</label>
                                <input type="text" id="cost" class="form-control" value="{{ $service->cost }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency" class="form-label">Currency</label>
                                <input type="text" id="currency" class="form-control"
                                    value="{{ strtoupper($service->currency) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frequency" class="form-label">Frequency</label>
                                <input type="text" id="frequency" class="form-control"
                                    value="{{ ucfirst($service->frequency) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eligibility" class="form-label">Eligibility</label>
                                <input type="text" id="eligibility" class="form-control"
                                    value="{{ ucfirst($service->eligibility) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" id="status" class="form-control"
                                    value="{{ ucfirst($service->status) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control" rows="3" readonly>{{ $service->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                <textarea id="terms_conditions" class="form-control" rows="3" readonly>{{ $service->terms_conditions }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('services.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
