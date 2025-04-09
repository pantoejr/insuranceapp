{{-- filepath: c:\Users\HP User\Desktop\Laravel Projects\insuranceapp\resources\views\policy_sub_types\edit.blade.php --}}
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('policySubTypes.update', $policySubType->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="policy_type_id" class="form-label">Policy Type</label>
                                    <select name="policy_type_id" id="policy_type_id"
                                        class="form-control @error('policy_type_id') is-invalid @enderror">
                                        <option value="">Select Policy Type</option>
                                        @foreach ($policyTypes as $policyType)
                                            <option value="{{ $policyType->id }}"
                                                {{ $policySubType->policy_type_id == $policyType->id ? 'selected' : '' }}>
                                                {{ $policyType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('policy_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $policySubType->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="2" class="form-control">{{ old('description', $policySubType->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('policySubTypes.index') }}" class="btn btn-light">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
