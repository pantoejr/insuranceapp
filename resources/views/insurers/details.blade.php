@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header">
                    <div class="card-title">Insurer Details</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2 text-center">
                            @if ($insurer->logo)
                                <img src="{{ asset('storage/' . $insurer->logo) }}" alt="Logo" style="max-width: 40%;"
                                    class="rounded-circle">
                            @else
                                <p>No logo available</p>
                            @endif
                            <br>
                            <a href="{{ route('insurers.index') }}" class="btn btn-light mt-3">Back to List</a>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" value="{{ $insurer->company_name }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Registration Number</label>
                                        <input type="text" value="{{ $insurer->registration_number }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Address</label>
                                        <input type="text" value="{{ $insurer->address }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Email</label>
                                        <input type="text" value="{{ $insurer->email }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Phone</label>
                                        <input type="text" value="{{ $insurer->phone }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Key Contact Person</label>
                                        <input type="text" value="{{ $insurer->key_contact_person }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Key Contact Email</label>
                                        <input type="text" value="{{ $insurer->key_contact_email }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Description</label>
                                        <textarea type="text" value="{{ $insurer->description }}" class="form-control" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Website URL</label>
                                        <input type="text" value="{{ $insurer->website_url }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="company_name" class="form-label">Status</label>
                                        <input type="text" value="{{ ucfirst($insurer->status) }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('insurers.partials.users_list', ['insurers' => $insurer])
@endsection
