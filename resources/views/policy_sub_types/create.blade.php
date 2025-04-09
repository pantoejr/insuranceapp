@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('policySubTypes.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="policy_type_id" class="form-label">Policy Type</label>
                                    <select name="policy_type_id" id="policy_type_id"
                                        class="form-control @error('policy_type_id')
                                        is-invalid
                                    @enderror">
                                        <option value="0">Select Policy Type</option>
                                        @foreach ($policyTypes as $policyType)
                                            <option value="{{ $policyType->id }}">{{ $policyType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('policy_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        name="name" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
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
