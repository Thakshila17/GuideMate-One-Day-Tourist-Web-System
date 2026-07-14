<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Attraction extends Model
{
    protected $fillable = [
        'name',
        'image',
        'category_id',
        'description',
        'location',
        'lat',
        'lng',
        'opening_hours',
        'closing_hours',
        'entry_fee',
        'contact_info',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
