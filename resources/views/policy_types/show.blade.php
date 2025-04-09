@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ $policyType->name }}" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" readonly id="description" class="form-control" cols="30" rows="3">{{ $policyType->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('policy-types.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
