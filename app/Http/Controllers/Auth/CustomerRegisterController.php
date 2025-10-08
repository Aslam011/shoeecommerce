<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerRegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('auth.customer-register');
    }

    /**
     * Handle registration with Email OTP verification
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:customers,email',
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', 'unique:customers,phone'],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.regex' => 'Name can only contain letters and spaces.',
            'phone.regex' => 'Phone number must be 10 digits starting with 6, 7, 8, or 9.',
            'email.unique' => 'This email is already registered. Please login instead.',
            'phone.unique' => 'This phone number is already registered. Please use a different number.',
        ]);

        // Verify that email OTP was verified
        $otpVerified = \DB::table('email_otps')
            ->where('email', $request->email)
            ->where('is_verified', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otpVerified) {
            return back()->withErrors([
                'email' => 'Please verify your email with OTP before registering.'
            ])->withInput();
        }

        // Create customer - already verified
        $customer = Customer::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'is_verified'=> true,
        ]);

        // Clean up used OTP
        \DB::table('email_otps')->where('email', $request->email)->delete();

        // Log in the customer
        Auth::guard('customer')->login($customer);

        return redirect()->route('home')->with('success', 'Account created successfully! Welcome to ShoeCommerce.');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm($id)
    {
        $customer = Customer::findOrFail($id);
        return view('auth.verify-otp', compact('customer'));
    }

    /**
     * Verify OTP
     */
  public function verifyOtp(Request $request, $id)
{
    $request->validate([
        'otp' => 'required',
    ]);

    $customer = Customer::findOrFail($id);

    if ($customer->otp_code === $request->otp) {
        $customer->is_verified = true;
        $customer->otp_code = null; // clear OTP
        $customer->save();

        Auth::guard('customer')->login($customer);

        return redirect()->route('home')->with('success', 'Account verified successfully!');
    }

    return back()->withErrors(['otp' => 'Invalid OTP.']);
}

}
