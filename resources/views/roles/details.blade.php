@extends('layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $role->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('roles.index') }}" class="btn btn-light">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @role('Superadmin')
        <div class="row">
            <div class="col-lg-6">
                @livewire('role.add-permission', ['roleId' => $role->id])
            </div>
            <div class="col-lg-6">
                @livewire('role.remove-permission', ['roleId' => $role->id])
            </div>
        </div>
    @endrole
@endsection
