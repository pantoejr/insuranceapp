@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('policy-types.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
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
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('policy-types.index') }}" class="btn btn-light">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
