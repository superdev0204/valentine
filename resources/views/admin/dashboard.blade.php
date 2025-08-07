@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center fw-bold text-dark mb-4">Admin Dashboard</h2>

                {{-- Section 1: User Management --}}
                <div class="card shadow-sm mb-4 border-danger">
                    <div class="card-header bg-danger text-white fw-semibold">
                        User Management
                    </div>
                    <div class="card-body d-grid gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-danger btn-lg">
                            <i class="bi bi-people me-2"></i> Manage Users
                        </a>
                    </div>
                </div>

                {{-- Section 2: System Settings --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light fw-semibold">
                        System Settings
                    </div>
                    <div class="card-body d-grid gap-3">
                        <a href="{{ route('admin.school-box-matrices') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-box me-2"></i> School Box Size Matrix
                        </a>
                        <a href="{{ route('admin.hospital-box-matrices') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-box me-2"></i> Hospital Box Size Matrix
                        </a>
                    </div>
                </div>

                {{-- Section 3: Organization Management --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-light fw-semibold">
                        Organization Management
                    </div>
                    <div class="card-body d-grid gap-3">
                        <a href="{{ route('admin.schools') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-building me-2"></i> Manage Schools
                        </a>
                        <a href="{{ route('admin.hospitals') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-heart-pulse me-2"></i> Manage Hospitals
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
