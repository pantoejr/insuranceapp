@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $systemVariable->name }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" name="type" id="type" class="form-control"
                            value="{{ $systemVariable->type }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="value" class="form-label">Value</label>
                        @if ($systemVariable->type == 'logo')
                            <div>
                                <img src="{{ asset('storage/' . $systemVariable->value) }}" alt="Logo Preview"
                                    style="max-width: 200px; margin-top: 10px;">
                            </div>
                        @else
                            <input type="text" name="value" id="value" class="form-control"
                                value="{{ $systemVariable->value }}" readonly>
                        @endif
                    </div>
                    <a href="{{ route('system-variables.index') }}" class="btn btn-white">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
