<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminLostPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('auth.admin.reset-password');
    }

    // UPDATE PASSWORD

    public function updatePassword(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|exists:admins,admin_name',
            'password' => 'required|confirmed|min:6',
        ]);

        $admin = Admin::where('admin_name', $request->admin_name)->first();

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect('/login')->with('status', 'Password updated successfully!');
    }
}
