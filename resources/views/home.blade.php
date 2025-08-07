@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="row justify-content-center align-items-center min-vh-50">
        <div class="col-md-8 text-center">
            <h1 class="display-3 fw-bold text-danger mb-4">Welcome to the Valentine website</h1>
            <p class="lead text-secondary mb-4">Your place to connect, share, and celebrate love.</p>
            <a href="{{ route('register') }}" class="btn btn-lg btn-danger me-2">Get Started</a>
            <a href="{{ route('login') }}" class="btn btn-lg btn-outline-danger">Login</a>
        </div>
    </div>
@endsection