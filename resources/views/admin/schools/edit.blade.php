@extends('layouts.app')

@section('title', 'Edit School')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-danger text-white d-flex align-items-center py-3">
                <i class="bi bi-building display-6 me-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">Edit School</h4>
                    <small class="opacity-75">Update school or organization information</small>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.schools.update', $school) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Organization Name -->
                        <div class="col-md-12 mb-3">
                            <label for="organization_name" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>Organization Name
                            </label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                   id="organization_name" name="organization_name" 
                                   value="{{ old('organization_name', $school->organization_name) }}" 
                                   placeholder="e.g., Lincoln Elementary School">
                            @error('organization_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>                    

                    <div class="row">
                        <!-- Contact Information -->
                        <div class="col-md-6 mb-3">
                            <label for="contact_person_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Contact Person Name
                            </label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" 
                                   id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name', $school->contact_person_name) }}" 
                                   placeholder="e.g., John Smith">
                            @error('contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="how_to_address" class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>How to Address You
                            </label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" 
                                   id="how_to_address" name="how_to_address" value="{{ old('how_to_address', $school->how_to_address) }}" 
                                   placeholder="e.g., Mr. Smith, Ms. Jones">
                            @error('how_to_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $school->email) }}" 
                                   placeholder="contact@school.edu">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i>Phone Number
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $school->phone) }}" 
                                   placeholder="(555) 123-4567">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Address Information -->
                        <div class="col-md-12 mb-3">
                            <label for="street" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Street Address
                            </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                   id="street" name="street" value="{{ old('street', $school->street) }}" 
                                   placeholder="123 Main Street">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>City
                            </label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $school->city) }}" 
                                   placeholder="Anytown">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label fw-semibold">
                                <i class="bi bi-map me-1"></i>State
                            </label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state', $school->state) }}" 
                                   placeholder="CA" maxlength="2">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="zip" class="form-label fw-semibold">
                                <i class="bi bi-pin-map me-1"></i>ZIP Code
                            </label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                   id="zip" name="zip" value="{{ old('zip', $school->zip) }}" 
                                   placeholder="12345" maxlength="5">
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quantities -->
                        <div class="col-md-6 mb-3">
                            <label for="envelope_quantity" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Envelope Quantity
                            </label>
                            <input type="number" class="form-control @error('envelope_quantity') is-invalid @enderror" 
                                   id="envelope_quantity" name="envelope_quantity" value="{{ old('envelope_quantity', $school->envelope_quantity) }}" 
                                   placeholder="100" min="0">
                            @error('envelope_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="instructions_cards" class="form-label fw-semibold">
                                <i class="bi bi-card-text me-1"></i>Instructions Cards
                            </label>
                            <input type="number" class="form-control @error('instructions_cards') is-invalid @enderror" 
                                   id="instructions_cards" name="instructions_cards" value="{{ old('instructions_cards', $school->instructions_cards) }}" 
                                   placeholder="50" min="0">
                            @error('instructions_cards')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Status and Additional Information -->
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1" {{ old('standing_order', $school->standing_order) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="standing_order">
                                    <i class="bi bi-check-circle me-1"></i>Standing Order
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Text Areas -->
                        <div class="col-md-12 mb-3">
                            <label for="question" class="form-label fw-semibold">
                                <i class="bi bi-question-circle me-1"></i>Questions or Comments
                            </label>
                            <textarea class="form-control @error('question') is-invalid @enderror" 
                                      id="question" name="question" rows="3" 
                                      placeholder="Any questions or additional information...">{{ old('question', $school->question) }}</textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="introducer" class="form-label fw-semibold">
                                <i class="bi bi-person-plus me-1"></i>Introducer
                            </label>
                            <textarea class="form-control @error('introducer') is-invalid @enderror" 
                                      id="introducer" name="introducer" rows="3" 
                                      placeholder="How did you hear about us?">{{ old('introducer', $school->introducer) }}</textarea>
                            @error('introducer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="prefilled_link" class="form-label fw-semibold">
                                <i class="bi bi-link-45deg me-1"></i>Prefilled Link
                            </label>
                            <textarea class="form-control @error('prefilled_link') is-invalid @enderror" 
                                      id="prefilled_link" name="prefilled_link" rows="3" 
                                      placeholder="Any prefilled links or references...">{{ old('prefilled_link', $school->prefilled_link) }}</textarea>
                            @error('prefilled_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="update_status" name="update_status" value="1" {{ old('update_status', $school->update_status) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="update_status">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Update Status
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.schools') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Update School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 