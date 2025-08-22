@extends('layouts.app')

@section('title', 'School and Group Sign-Up')

@section('content')
<style>
    body {
        background-color: #f9f0f4; /* soft pink background */
    }
    .form-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    .form-header {
        background-color: #a61c4c; /* dark pink accent bar */
        height: 8px;
    }
    .form-body {
        padding: 24px;
    }
    .form-title {
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-desc {
        font-size: 0.95rem;
        color: #444;
        margin-bottom: 1rem;
    }
    .form-section {
        border-top: 1px solid #eee;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
</style>

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Logo -->
            <div class="text-center mb-4">
                <h1 class="fw-bold text-danger" style="font-family: 'Pacifico', cursive; font-size: 3rem;">
                    Valentines By Kids
                </h1>
            </div>

            <!-- Card -->
            <div class="form-card">
                <!-- Accent bar -->
                <div class="form-header"></div>

                <!-- Body -->
                <div class="form-body">
                    <div class="form-title">School and Group Sign-Up Form</div>
                    <div class="form-desc">
                        <strong>You have found the place to sign up your school or organization to participate in Valentines By Kids for 2026. 
                        But don’t put it off – when we hit 170 schools (limited by our funding), we will close registration.   
                        We have about 18 slots left.</strong>
                        <br><br>
                        Schools, Scouts, churches, and other groups can sign up here to draw Valentine's Day cards for hospitals/hospices/charities and Food & Friends.
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('school.register.store') }}" method="POST">
                        @csrf

                        <!-- Question 1 -->
                        {{-- <div class="form-section">
                            <label class="form-label">
                                Will you participate to create wonderful Valentine’s Day cards? <span class="text-danger">*</span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="yes" id="yes" required>
                                <label class="form-check-label" for="yes">YES! Count us in!</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="no" id="no">
                                <label class="form-check-label" for="no">No, we will not. Please remove our name from your list.</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="other" id="other">
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div> --}}

                        <!-- Question 2 -->
                        <div class="form-section">
                            <label for="organization_name" class="form-label">Name of School or Organization <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                id="organization_name" name="organization_name">
                            @error('organization_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Person -->
                        <div class="form-section">
                            <label for="contact_person_name" class="form-label">Contact Person's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" id="contact_person_name" name="contact_person_name">
                            @error('contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-section">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="how_to_address" class="form-label">How to address you (like "Ms. Jones") <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" id="how_to_address" name="how_to_address">
                            @error('how_to_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantities -->
                        <div class="form-section">
                            <label for="envelope_quantity" class="form-label">Quantity of empty <a href="https://tinyurl.com/EnvelopeFront">Valentine's envelopes</a> we should send to you.  (Please estimate realistically - We promise hospitals quantities based upon the number of envelopes you request and, if you return fewer, we can't fulfill the promise - Thank you!) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('envelope_quantity') is-invalid @enderror" id="envelope_quantity" name="envelope_quantity">
                            @error('envelope_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="instructions_cards" class="form-label">Each teacher will receive an <a href="http://tinyurl.com/ValentineTeacherInstructions">instructions card</a>.  How many instructions cards shall we include?</label>
                            <input type="number" class="form-control @error('instructions_cards') is-invalid @enderror" id="instructions_cards" name="instructions_cards">
                            @error('instructions_cards')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Information -->
                        <div class="form-section">
                            <label for="street" class="form-label"><b>Street Address</b> for delivery of envelopes to you: (without city/state -- just the street address) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="state" class="form-label">State/District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="zip" class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip">
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-section">
                            <label for="phone" class="form-label">Phone (Fedex requires in case they have an issue - enter digits only, no spaces, dashes, or parentheses): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status and Additional Information -->
                        <div class="form-section">
                            <label for="standing_order" class="form-label">Do you want to make this a standing order (we just send you the same amount in future years), so you don't have to remember? It would make it easier for you and for us.</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1" {{ old('standing_order', true) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Text Areas -->
                        <div class="form-section">
                            <label for="question" class="form-label">Any other questions or thoughts to share?</label>
                            <textarea class="form-control @error('question') is-invalid @enderror" 
                                    id="question" name="question" rows="3">{{ old('question') }}</textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="introducer" class="form-label">How did you find out about Valentines By Kids?</label>
                            <textarea class="form-control @error('introducer') is-invalid @enderror" 
                                    id="introducer" name="introducer" rows="3">{{ old('introducer') }}</textarea>
                            @error('introducer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="form-section d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        
                            <!-- Reset button -->
                            <button type="reset" class="btn btn-outline-secondary">Clear Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
