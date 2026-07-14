<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'color', 'status'];

    public function attractions()
    {
        return $this->hasMany(Attraction::class);
    }
}
