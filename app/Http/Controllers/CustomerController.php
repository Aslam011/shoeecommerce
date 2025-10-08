<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name'     => 'required|string|min:2',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'required|digits:10|unique:customers,phone',
            'password' => 'required|min:6|confirmed',
        ]);
        
dd($request->all());

        // Save to DB
        Customer::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'is_verified'=> 1,
        ]);

        return redirect()->back()->with('success', 'Account created successfully!');
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }
}
