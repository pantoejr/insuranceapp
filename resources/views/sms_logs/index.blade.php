@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($smsLogs as $smsLog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $smsLog->phone_number }}</td>
                                        <td>{{ $smsLog->message }}</td>
                                        <td>{{ $smsLog->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
