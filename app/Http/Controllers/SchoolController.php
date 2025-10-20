<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class SchoolController extends Controller
{
    public function create()
    {
        return view('schools.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'   => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name' => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'               => 'required|email|max:255',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'               => ['required', 'size:2', 'alpha'],
            'zip'                 => 'required|string|max:20',
            'phone'               => ['required', 'digits:10'],
            'standing_order'      => 'boolean',
            'public_notes'            => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $school = School::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $allData
        );

        do {
            $token = Str::random(8);
        } while (School::where('token', $token)->exists());

        $school->token = $token;
        $school->prefilled_link = url('/school/' . $token . '/edit');
        $school->save();

        $subject = 'Valentine notification';
        $message = 'Thank you, so much!  We have updated our database with your information.  
                    We usually send out the boxes of envelopes in December and the deadline for you to call Fedex for pickup is January 31. 
                    The Teacher Instructions Card can be found here https://tinyurl.com/ValentineTeacherInstructions.  
                    Any questions, just let us know.';

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($school->email)->send(new SendEmail($data));

        return redirect()
            ->back()
            ->with('success', 'Thank you for registering! We will contact you soon.');
    }

    public function edit($token)
    {
        $school = School::where('token', $token)->firstOrFail();
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, $token)
    {
        $school = School::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'organization_name'   => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name' => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'               => 'required|email|max:255',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'               => ['required', 'size:2', 'alpha'],
            'zip'                 => 'required|string|max:20',
            'phone'               => ['required', 'digits:10'],
            'standing_order'      => 'boolean',
            'public_notes'            => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;
        
        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $school->update($allData);

        // $school->prefilled_link = url('/school/' . $school->id . '/edit');
        $school->save();

        $subject = 'Valentine notification';
        $message = 'Thank you, so much!  We have updated our database with your information.  
                    We usually send out the boxes of envelopes in December and the deadline for you to call Fedex for pickup is January 31. 
                    The Teacher Instructions Card can be found here https://tinyurl.com/ValentineTeacherInstructions.  
                    Any questions, just let us know.
                    We will send you ' . $school->envelope_quantity . ' envelopes.';

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($school->email)->send(new SendEmail($data));
        
        return redirect()
            ->back()
            ->with('success', 'School updated successfully.');
    }

}