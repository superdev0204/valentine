<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function create()
    {
        return view('schools.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'   => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => 'required|string|max:255',
            'city'                => 'required|string|max:255',
            'state'               => 'required|string|max:255',
            'zip'                 => 'required|string|max:20',
            'phone'               => 'required|string|max:20',
            'standing_order'      => 'boolean',
            'question'            => 'nullable|string',
            'introducer'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        School::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $validated
        );

        return redirect()
            ->back()
            ->with('success', 'Thank you for registering! We will contact you soon.');
    }

    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'organization_name'   => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => 'required|string|max:255',
            'city'                => 'required|string|max:255',
            'state'               => 'required|string|max:255',
            'zip'                 => 'required|string|max:20',
            'phone'               => 'required|string|max:20',
            'standing_order'      => 'boolean',
            'question'            => 'nullable|string',
            'introducer'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        $school->update($validated);
        return redirect()
            ->back()
            ->with('success', 'School updated successfully.');
    }

}