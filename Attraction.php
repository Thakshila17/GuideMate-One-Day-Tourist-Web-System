<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'name',
        'image',
        'category',
        'description',
        'opening_hours',
        'closing_hours',
        'contact_info',
        'entry_fee',
        'lat',
        'lng',
        'location'
    ];
}
