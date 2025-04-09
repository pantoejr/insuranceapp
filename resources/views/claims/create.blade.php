@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('claims.create', ['client' => $client]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="hidden" value="{{ $client->id }}" name="client_id">
                                    <label for="policy_id" class="form-label">Policy</label>
                                    <select name="policy_id" id="policy_id"
                                        class="form-control @error('policy_id')
                                        is-invalid
                                    @enderror">
                                        <option value="0">Select Policy</option>
                                        @foreach ($policies as $policy)
                                            <option value="{{ $policy->id }}">{{ $policy->policyType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('policy_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number"
                                        class="form-control @error('amount')
                                        is-invalid
                                    @enderror"
                                        name="amount">
                                    @error('amount')
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="claim_type" class="form-label">Claim Type</label>
                                    <textarea name="claim_type"
                                        class="form-control @error('claim_type')
                                        is-invalid
                                    @enderror"
                                        id="claim_type" cols="30" rows="2"></textarea>
                                    @error('claim_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description"
                                        class="form-control @error('description')
                                        is-invalid
                                    @enderror"
                                        id="description" cols="30" rows="2"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="claim_document" class="form-label">Document</label>
                                    <input type="file" class="form-control" name="claim_document[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                        class="btn btn-light">Back To List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
