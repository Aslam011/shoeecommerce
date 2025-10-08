<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'pincode'       => 'required|digits:6',
            'flat_house_no' => 'required|string|max:255',
            'area_street'   => 'required|string|max:255',
            'landmark'      => 'nullable|string|max:255',
            'town_city'     => 'required|string|max:255',
            'state'         => 'required|string|max:255',
        ]);

        // Split full_name into first and last name
        $nameParts = explode(' ', trim($request->full_name), 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        // Build full address string
        $fullAddress = trim($request->flat_house_no . ', ' . $request->area_street . 
                      ($request->landmark ? ', ' . $request->landmark : ''));

        $address = new Address();
        $address->customer_id   = Auth::guard('customer')->id();
        $address->first_name    = $firstName;
        $address->last_name     = $lastName;
        $address->email         = Auth::guard('customer')->user()->email;
        $address->phone         = $request->mobile_number;
        $address->address       = $fullAddress;
        $address->city          = $request->town_city;
        $address->state         = $request->state;
        $address->postal_code   = $request->pincode;
        $address->country       = 'India';
        $address->type          = 'home';
        $address->is_default    = $request->has('default_address') ? 1 : 0;

        $address->save();

        return response()->json([
            'success' => true,
            'address_id' => $address->id,
            'address' => $address
        ]);
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $request->validate([
            'full_name'     => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'pincode'       => 'required|digits:6',
            'flat_house_no' => 'required|string|max:255',
            'area_street'   => 'required|string|max:255',
            'landmark'      => 'nullable|string|max:255',
            'town_city'     => 'required|string|max:255',
            'state'         => 'required|string|max:255',
        ]);

        // Split full_name into first and last name
        $nameParts = explode(' ', trim($request->full_name), 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        // Build full address string
        $fullAddress = trim($request->flat_house_no . ', ' . $request->area_street . 
                      ($request->landmark ? ', ' . $request->landmark : ''));

        $address->first_name    = $firstName;
        $address->last_name     = $lastName;
        $address->phone         = $request->mobile_number;
        $address->address       = $fullAddress;
        $address->city          = $request->town_city;
        $address->state         = $request->state;
        $address->postal_code   = $request->pincode;
        $address->is_default    = $request->has('default_address') ? 1 : 0;

        $address->save();

        return response()->json([
            'success' => true,
            'address_id' => $address->id,
            'address' => $address,
            'message' => 'Address updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $address = Address::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }
}
