<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'participation',
        'organization_name',
        'contact_person_name',
        'email',
        'how_to_address',
        'envelope_quantity',
        'instructions_cards',
        'street',
        'city',
        'state',
        'zip',
        'phone',
        'standing_order',
        'question',
        'introducer',
        'prefilled_link',
        'update_status',
    ];

    protected $casts = [
        'envelope_quantity' => 'integer',
        'instructions_cards' => 'integer',
        'standing_order' => 'boolean',
        'email_status' => 'boolean',
        'update_status' => 'boolean',
    ];
}
