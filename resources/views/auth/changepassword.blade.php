@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 pt-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    {{ $title }}
                </div>
                <div class="card-body login-card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('confirm-change-password') }}" method="POST">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="current_password" type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" placeholder="Current Password" required>
                                <label for="current_password">Current Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        @error('current_password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="new_password" type="password"
                                    class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                    placeholder="New Password" required>
                                <label for="new_password">New Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        @error('new_password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="new_password_confirmation" type="password" class="form-control"
                                    name="new_password_confirmation" placeholder="Confirm New Password" required>
                                <label for="new_password_confirmation">Confirm New Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="mb-1 text-center"><a href="{{ route('app.index') }}">Back to dashboard</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
