@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold text-dark mb-5">Admin Dashboard</h2>

    <div class="row justify-content-center g-4">

        {{-- User Management --}}
        <div class="col-lg-8">
            <div class="card shadow border-danger rounded-4">
                <div class="card-header bg-danger text-white fw-bold rounded-top-4">
                    <i class="bi bi-people me-2"></i> User Management
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users') }}" class="btn btn-danger btn-lg w-100 mb-2">
                        <i class="bi bi-people me-2"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>

        {{-- System Settings --}}
        <div class="col-lg-8">
            <div class="card shadow border-primary rounded-4">
                <div class="card-header bg-primary text-white fw-bold rounded-top-4">
                    <i class="bi bi-gear me-2"></i> System Settings
                </div>
                <div class="card-body d-grid gap-3">
                    <a href="{{ route('admin.school-box-matrices') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-box me-2"></i> School Box Size Matrix
                    </a>
                    <a href="{{ route('admin.hospital-box-matrices') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-box me-2"></i> Hospital Box Size Matrix
                    </a>
                    <a href="{{ route('admin.fedex_mappings.school_outgoing') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-truck me-2"></i> School Outgoing FedEx Field Mappings
                    </a>
                    <a href="{{ route('admin.fedex_mappings.school_return') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-arrow-return-left me-2"></i> School Return FedEx Field Mappings
                    </a>
                    <a href="{{ route('admin.fedex_mappings.hospital_outgoing') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-hospital me-2"></i> Hospital Outgoing FedEx Field Mappings
                    </a>
                </div>
            </div>
        </div>

        {{-- Organization Management --}}
        <div class="col-lg-8">
            <div class="card shadow border-success rounded-4">
                <div class="card-header bg-success text-white fw-bold rounded-top-4">
                    <i class="bi bi-building me-2"></i> Organization Management
                </div>
                <div class="card-body d-grid gap-3">
                    <a href="{{ route('admin.schools') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-building me-2"></i> Manage Schools
                    </a>
                    <a href="{{ route('admin.hospitals') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-heart-pulse me-2"></i> Manage Hospitals
                    </a>
                    <a href="{{ route('admin.volunteers') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-person-badge me-2"></i> Manage Volunteers
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .card-header {
        font-size: 1.2rem;
    }
    .btn-lg {
        border-radius: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
</style>
@endsection
