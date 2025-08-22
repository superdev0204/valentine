@extends('layouts.app')

@section('title', 'Edit School')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.schools.update', $school) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- School Information Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <i class="bi bi-building display-6 me-2"></i>
                    <span class="fs-5 fw-bold">School Information</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="organization_name" class="form-label fw-semibold">Organization Name</label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror"
                                   id="organization_name" name="organization_name"
                                   value="{{ old('organization_name', $school->organization_name) }}"
                                   placeholder="e.g., Lincoln Elementary School">
                            @error('organization_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label fw-semibold">Contact Person Name</label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror"
                                   id="contact_person_name" name="contact_person_name"
                                   value="{{ old('contact_person_name', $school->contact_person_name) }}"
                                   placeholder="e.g., John Smith">
                            @error('contact_person_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="how_to_address" class="form-label fw-semibold">How to Address You</label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror"
                                   id="how_to_address" name="how_to_address"
                                   value="{{ old('how_to_address', $school->how_to_address) }}"
                                   placeholder="e.g., Mr. Smith, Ms. Jones">
                            @error('how_to_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $school->email) }}"
                                   placeholder="contact@school.edu">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $school->phone) }}"
                                   placeholder="(555) 123-4567">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street" class="form-label fw-semibold">Street Address</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror"
                                   id="street" name="street" value="{{ old('street', $school->street) }}"
                                   placeholder="123 Main Street">
                            @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city', $school->city) }}" placeholder="Anytown">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                   id="state" name="state" value="{{ old('state', $school->state) }}" placeholder="CA" maxlength="2">
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label fw-semibold">ZIP Code</label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                   id="zip" name="zip" value="{{ old('zip', $school->zip) }}" placeholder="12345" maxlength="5">
                            @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quantities & Volunteer Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <i class="bi bi-box-seam display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Quantities & Volunteer</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="envelope_quantity" class="form-label fw-semibold">Envelope Quantity</label>
                            <input type="number" class="form-control @error('envelope_quantity') is-invalid @enderror"
                                   id="envelope_quantity" name="envelope_quantity"
                                   value="{{ old('envelope_quantity', $school->envelope_quantity) }}" min="0">
                            @error('envelope_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="instructions_cards" class="form-label fw-semibold">Instructions Cards</label>
                            <input type="number" class="form-control @error('instructions_cards') is-invalid @enderror"
                                   id="instructions_cards" name="instructions_cards"
                                   value="{{ old('instructions_cards', $school->instructions_cards) }}" min="0">
                            @error('instructions_cards') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="standing_order" class="form-label fw-semibold">Standing Order</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1"
                                       {{ old('standing_order', $school->standing_order) ? 'checked' : '' }}>
                                <label class="form-check-label" for="standing_order">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="qty_sent_last_year" class="form-label fw-semibold">Qty Sent Last Year</label>
                            <input type="number" class="form-control @error('qty_sent_last_year') is-invalid @enderror"
                                   id="qty_sent_last_year" name="qty_sent_last_year"
                                   value="{{ old('qty_sent_last_year', $school->qty_sent_last_year) }}" min="0">
                            @error('qty_sent_last_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="qty_received_last_year" class="form-label fw-semibold">Qty Received Last Year</label>
                            <input type="number" class="form-control @error('qty_received_last_year') is-invalid @enderror"
                                   id="qty_received_last_year" name="qty_received_last_year"
                                   value="{{ old('qty_received_last_year', $school->qty_received_last_year) }}" min="0">
                            @error('qty_received_last_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="volunteer_id" class="form-label fw-semibold">Assign Volunteer</label>
                            <select class="form-select @error('volunteer_id') is-invalid @enderror" id="volunteer_id" name="volunteer_id">
                                <option value="">— Select Volunteer —</option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}"
                                        {{ old('volunteer_id', $school->volunteer_id) == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }} ({{ $volunteer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('volunteer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes / Comments Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-secondary text-white py-3">
                    <i class="bi bi-chat-left-text display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Questions / Comments</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="question" class="form-label fw-semibold">Questions or Comments</label>
                        <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="3">{{ old('question', $school->question) }}</textarea>
                        @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="introducer" class="form-label fw-semibold">How Did You Hear About Us?</label>
                        <textarea class="form-control @error('introducer') is-invalid @enderror" id="introducer" name="introducer" rows="2">{{ old('introducer', $school->introducer) }}</textarea>
                        @error('introducer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.schools') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Update School
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
