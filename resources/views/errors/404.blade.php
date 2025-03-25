@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
    <div class="container text-center">
        <h1 class="display-1">404</h1>
        <p class="lead">Page Not Found</p>
        <p>The page you are looking for could not be found.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
    </div>
@endsection
