<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
        $user = Auth::guard('customer')->user();
        if ($user->is_verified != 1) {
            Auth::guard('customer')->logout();
            return back()->with('error', 'Please verify your account before logging in.');
        }
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }
    return back()->with('error', 'Invalid email or password.');
}


    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
}
