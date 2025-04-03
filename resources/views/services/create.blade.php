@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name')
                                        is-invalid
                                   @enderror"
                                        required>
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
                                        class="form-control @error('description')
                                        is-invalid
                                   @enderror"></textarea>
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
                                        class="form-control @error('terms_conditions')
                                        is-invalid
                                   @enderror"></textarea>
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
                                        class="form-control @error('eligibility')
                                        is-invalid
                                   @enderror">
                                        <option value="0">Select Eligibility</option>
                                        <option value="individual">Individual</option>
                                        <option value="company">Company</option>
                                        <option value="both">Both</option>
                                    </select>
                                    @error('eligibility')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" mb-3>
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="number" name="cost"
                                        class="form-control @error('cost')
                                        is-invalid
                                   @enderror">
                                    @error('cost')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" id="currency"
                                        class="form-control @error('currency')
                                       is-invalid
                                  @enderror">
                                        <option value="0">Select Currency</option>
                                        <option value="usd">USD</option>
                                        <option value="lrd">LRD</option>
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
                                        class="form-control @error('frequency')
                                       is-invalid
                                  @enderror">
                                        <option value="0">Select Frequency</option>
                                        @foreach (['monthly', 'quartely', 'half-yearly', 'yearly', 'bi-yearly', 'tri-yearly', 'four-yearly', 'five-yearly'] as $frequency)
                                            <option value="{{ $frequency }}">{{ ucfirst($frequency) }}</option>
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
                                        class="form-control @error('status')
                                       is-invalid
                                  @enderror">
                                        <option value="0">Select Status</option>
                                        @foreach (['active', 'inactive'] as $status)
                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                        @endforeach
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
                                    <button type="submit" class="btn btn-success">Save</button>
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
