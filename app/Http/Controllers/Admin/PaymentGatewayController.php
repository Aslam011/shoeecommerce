<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    /**
     * Display payment gateways management page
     */
    public function index()
    {
        $gateways = PaymentGateway::orderBy('sort_order')->get();
        return view('admin.payment-gateways.index', compact('gateways'));
    }

    /**
     * Toggle payment gateway active status
     */
    public function toggle(Request $request, PaymentGateway $gateway)
    {
        // Check if gateway is configured before activating
        if (!$gateway->is_active && !$gateway->isConfigured()) {
            return back()->with('error', 'Please configure the payment gateway before activating it.');
        }

        $gateway->update([
            'is_active' => !$gateway->is_active
        ]);

        $status = $gateway->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "{$gateway->display_name} has been {$status}.");
    }

    /**
     * Update payment gateway configuration
     */
    public function update(Request $request, PaymentGateway $gateway)
    {
        $rules = [
            'environment' => 'required|in:test,live',
        ];

        // Dynamic validation based on gateway type
        switch ($gateway->name) {
            case 'razorpay':
                $rules['api_key'] = 'required|string';
                $rules['api_secret'] = 'required|string';
                $rules['webhook_secret'] = 'nullable|string';
                break;

            case 'phonepe':
                $rules['merchant_id'] = 'required|string';
                $rules['salt_key'] = 'required|string';
                $rules['salt_index'] = 'required|string';
                break;

            case 'paytm':
                $rules['merchant_id'] = 'required|string';
                $rules['api_key'] = 'required|string'; // Merchant Key
                $rules['api_secret'] = 'nullable|string';
                break;

            case 'cashfree':
                $rules['api_key'] = 'required|string'; // App ID
                $rules['api_secret'] = 'required|string'; // Secret Key
                break;
        }

        $validated = $request->validate($rules);

        $gateway->update($validated);

        return back()->with('success', "{$gateway->display_name} configuration updated successfully!");
    }
}
