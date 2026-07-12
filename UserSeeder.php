<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('username', 'johnPerera')->exists()) {
            User::create([
                'username' => 'johnPerera',
                'email' => 'john@gmail.com',
                'password' => Hash::make('john123'),
                'role' => 'user'
            ]);
        }
    }
}
