<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'admin_name',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
