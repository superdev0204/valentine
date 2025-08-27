<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
            'question'              => 'nullable|string',
            // 'introducer'            => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        Hospital::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $validated
        );

        return redirect()
            ->back()
            ->with('success', 'Thank you for registering! We will contact you soon.');
    }

    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
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
            'question'            => 'nullable|string',
            // 'introducer'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        $hospital->update($validated);
        return redirect()
            ->back()
            ->with('success', 'Hospital updated successfully.');
    }
}