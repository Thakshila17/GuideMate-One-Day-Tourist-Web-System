<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!Admin::where('admin_name', 'admin')->exists()) {
            Admin::create([
                'admin_name' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
