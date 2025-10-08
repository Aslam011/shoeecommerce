<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    // Show the form to request password reset
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Handle direct password reset
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
            'phone' => 'required|string|exists:customers,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find customer by email and phone
        $customer = Customer::where('email', $request->email)
                           ->where('phone', $request->phone)
                           ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email and phone combination.'
            ]);
        }

        // Update password
       // Update password
$customer->password = Hash::make($request->password);
$customer->save();

return redirect()->route('customer.login')
                 ->with('success', 'Password updated successfully! Please log in.');

    }

    // API endpoint to verify email and phone combination
    public function verifyCredentials(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $exists = Customer::where('email', $request->email)
                         ->where('phone', $request->phone)
                         ->exists();

        return response()->json([
            'valid' => $exists
        ]);
    }
}
