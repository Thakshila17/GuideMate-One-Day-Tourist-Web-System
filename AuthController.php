<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // USER LOGIN  
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'user')
                ->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Invalid username or password!',
        ], 'user')->withInput();
    }

    // ADMIN LOGIN 
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'admin')
                ->withInput();
        }

        $credentials = [
            'admin_name' => $request->admin_name,
            'password' => $request->password
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            Auth::shouldUse('admin');

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'admin_name' => 'Invalid admin name or password!',
        ], 'admin')->withInput();
    }
}
