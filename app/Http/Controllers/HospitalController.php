<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HospitalController extends Controller
{
    public function create()
    {
        return view('hospitals.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'     => 'required|string|max:255',
            'organization_type'     => 'required|string|max:255',
            'contact_person_name'   => 'required|string|max:255',
            'email'                 => 'required|email|max:255',
            'how_to_address'        => 'required|string|max:255',
            'valentine_card_count'  => 'required|integer|min:0',
            'extra_staff_cards'     => 'nullable|integer|min:0',
            'street'                => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'state'                 => 'required|string|max:255',
            'zip'                   => 'required|string|max:20',
            'phone'                 => 'required|string|max:20',
            'standing_order'        => 'boolean',
            'public_notes'              => 'nullable|string',
            // 'internal_notes'            => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $hospital = Hospital::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $allData
        );

        do {
            $token = Str::random(8);
        } while (Hospital::where('token', $token)->exists());

        $hospital->token = $token;
        $hospital->prefilled_link = url('/hospital/' . $token . '/edit');
        $hospital->save();

        $subject = 'Valentine notification';
        $message = 'Thank you, so much!  We have updated our database with your information.  
                    We usually send out the Valentines for arrival the first week of February.  
                    These cards are made by hand, felt by hearts.  
                    Any questions you may have, just let us know.';

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($hospital->email)->send(new SendEmail($data));

        return redirect()
            ->back()
            ->with('success', 'Thank you for registering! We will contact you soon.');
    }

    public function edit($token)
    {
        $hospital = Hospital::where('token', $token)->firstOrFail();
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, $token)
    {
        $hospital = Hospital::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'valentine_card_count' => 'required|integer|min:0',
            'extra_staff_cards'  => 'nullable|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            'public_notes'            => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $hospital->update($allData);
        
        // $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');
        $hospital->save();

        $subject = 'Valentine notification';
        // $message = 'Dear ' . ($hospital->how_to_address ? $hospital->how_to_address : 'Friend') . ', our database has been successfully';
        $message = $hospital;

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($hospital->email)->send(new SendEmail($data));
        
        return redirect()
            ->back()
            ->with('success', 'Hospital updated successfully.');
    }
}