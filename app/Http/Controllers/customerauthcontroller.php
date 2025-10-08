<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer; // ✅ import model

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        // ✅ validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // ✅ attempt login with remember
        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate(); // ✅ refresh session

            return redirect()->route('customer.dashboard')
                ->with('success', 'Welcome back!');
        }

        // login failed
        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }

    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function showOtpForm(Request $request)
    {
        return view('auth.customer-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        $customer = Customer::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$customer) {
            return back()->withErrors(['otp_code' => 'Invalid OTP']);
        }

        $customer->is_verified = true;
        $customer->otp_code = null;
        $customer->save();

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Account verified successfully 🎉');
    }
}
