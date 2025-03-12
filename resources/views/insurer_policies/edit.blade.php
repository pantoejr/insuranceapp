@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">Edit Insurer Policy</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('insurer-policies.update', $insurerPolicy->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="insurer_id" class="form-label">Insurer</label>
                            <select class="form-control @error('insurer_id') is-invalid @enderror" id="insurer_id"
                                name="insurer_id" required>
                                @foreach ($insurers as $insurer)
                                    <option value="{{ $insurer->id }}"
                                        {{ old('insurer_id', $insurerPolicy->insurer_id) == $insurer->id ? 'selected' : '' }}>
                                        {{ $insurer->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('insurer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="policy_id" class="form-label">Policy</label>
                            <select class="form-control @error('policy_id') is-invalid @enderror" id="policy_id"
                                name="policy_id" required>
                                @foreach ($policies as $policy)
                                    <option value="{{ $policy->id }}"
                                        {{ old('policy_id', $insurerPolicy->policy_id) == $policy->id ? 'selected' : '' }}>
                                        {{ $policy->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('policy_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active"
                                    {{ old('status', $insurerPolicy->status) == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive"
                                    {{ old('status', $insurerPolicy->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('insurer-policies.index') }}" class="btn btn-light">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
