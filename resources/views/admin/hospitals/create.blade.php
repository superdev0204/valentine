@extends('layouts.app')

@section('title', 'Add New Hospital')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.hospitals.store') }}" method="POST">
            @csrf

            <!-- Hospital Information Card (including Address) -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <i class="bi bi-heart-pulse display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Hospital Information</span>
                </div>
                <div class="card-body">

                    <!-- Organization & Contact -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="organization_name" class="form-label fw-semibold">Organization Name</label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                   id="organization_name" name="organization_name" value="{{ old('organization_name') }}" 
                                   placeholder="e.g., Memorial Hospital">
                            @error('organization_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="organization_type" class="form-label fw-semibold">Organization Type</label>
                            <input type="text" class="form-control @error('organization_type') is-invalid @enderror" 
                                   id="organization_type" name="organization_type" value="{{ old('organization_type') }}" 
                                   placeholder="Hospital, Clinic">
                            @error('organization_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label fw-semibold">Contact Person Name</label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" 
                                   id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name') }}" 
                                   placeholder="Dr. Smith">
                            @error('contact_person_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="how_to_address" class="form-label fw-semibold">How to Address</label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" 
                                   id="how_to_address" name="how_to_address" value="{{ old('how_to_address') }}" 
                                   placeholder="Dr. Smith, Ms. Jones">
                            @error('how_to_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="contact@hospital.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="(555) 123-4567">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street" class="form-label fw-semibold">Street Address</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                   id="street" name="street" value="{{ old('street') }}" placeholder="123 Medical Center Drive">
                            @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" placeholder="City">
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state') }}" placeholder="CA" maxlength="2">
                            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label fw-semibold">ZIP Code</label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                   id="zip" name="zip" value="{{ old('zip') }}" placeholder="12345" maxlength="5">
                            @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Cards / Staff -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <i class="bi bi-card-checklist display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Cards & Staff</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="valentine_card_count" class="form-label fw-semibold">Valentine Card Count</label>
                            <input type="number" class="form-control @error('valentine_card_count') is-invalid @enderror" 
                                   id="valentine_card_count" name="valentine_card_count" value="{{ old('valentine_card_count') }}" min="0">
                            @error('valentine_card_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="extra_staff_cards" class="form-label fw-semibold">Extra Staff Cards</label>
                            <input type="number" class="form-control @error('extra_staff_cards') is-invalid @enderror" 
                                   id="extra_staff_cards" name="extra_staff_cards" value="{{ old('extra_staff_cards') }}" min="0">
                            @error('extra_staff_cards')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1" {{ old('standing_order', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="standing_order">Standing Order</label>
                    </div>
                </div>
            </div>

            <!-- Notes / Comments -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-secondary text-white py-3">
                    <i class="bi bi-chat-left-text display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Questions / Comments</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="question" class="form-label fw-semibold">Questions or Comments</label>
                        <textarea class="form-control @error('question') is-invalid @enderror" 
                                  id="question" name="question" rows="3">{{ old('question') }}</textarea>
                        @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="introducer" class="form-label fw-semibold">Introducer</label>
                        <textarea class="form-control @error('introducer') is-invalid @enderror" 
                                  id="introducer" name="introducer" rows="2">{{ old('introducer') }}</textarea>
                        @error('introducer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.hospitals') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create Hospital
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
