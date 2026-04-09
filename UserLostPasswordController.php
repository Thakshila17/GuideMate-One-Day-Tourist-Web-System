<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserLostPasswordController extends Controller
{
    // Show form
    public function showResetForm()
    {
        return view('auth.user.reset-password');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('username', $request->username)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('status', 'Password updated successfully!');
    }
}
