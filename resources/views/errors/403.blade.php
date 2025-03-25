@extends('layouts.app')

@section('title', '403 Forbidden')

@section('content')
    <div class="container text-center">
        <h1 class="display-1">403</h1>
        <p class="lead">Forbidden</p>
        <p>You do not have permission to access this page.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
    </div>
@endsection
