@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Insurer Details</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($insurer->logo)
                                <img src="{{ asset('storage/' . $insurer->logo) }}" alt="Logo"
                                    style="max-width: 100%; border: 1px solid #ddd;">
                            @else
                                <p>No logo available</p>
                            @endif
                            <a href="{{ route('insurers.index') }}" class="btn btn-light mt-3">Back to List</a>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table ">
                                    <tr>
                                        <th>Company Name</th>
                                        <td>{{ $insurer->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registration Number</th>
                                        <td>{{ $insurer->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $insurer->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $insurer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $insurer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Key Contact Person</th>
                                        <td>{{ $insurer->key_contact_person }}</td>
                                    </tr>
                                    <tr>
                                        <th>Key Contact Email</th>
                                        <td>{{ $insurer->key_contact_email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $insurer->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Website URL</th>
                                        <td><a href="{{ $insurer->website_url }}"
                                                target="_blank">{{ $insurer->website_url }}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ ucfirst($insurer->status) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
