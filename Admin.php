<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'admin_name',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the name of the unique identifier for the admin.
     */
    public function getAuthIdentifierName()
    {
        return 'admin_name';
    }

    /**
     * Get the password for the admin.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
