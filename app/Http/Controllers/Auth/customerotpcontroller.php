<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CustomerOtpController extends Controller
{
    /**
     * Handle send/resend OTP for phone verification.
     * Expects JSON: { phone: "9876543210", action: "send"|"resend" }
     */
    public function send(Request $request): JsonResponse
    {
        // Validate input
        $data = $request->validate([
            'phone'  => ['required', 'regex:/^[6-9]\d{9}$/'],
            'action' => ['nullable', 'in:send,resend'],
        ]);

        $phone = $data['phone'];
        $action = $data['action'] ?? 'send';

        // Keys for cache
        $otpKey          = "otp:code:{$phone}";
        $cooldownUntilKey= "otp:cooldown-until:{$phone}";

        // Enforce 30s cooldown between sends for the same phone
        $cooldownUntil = Cache::get($cooldownUntilKey);
        if ($cooldownUntil && now()->lt($cooldownUntil)) {
            $seconds = now()->diffInSeconds($cooldownUntil);
            return response()->json([
                'success' => false,
                'message' => "Please wait {$seconds} seconds before requesting another OTP.",
                'cooldown' => $seconds,
            ], 429);
        }

        // Generate a 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // Store OTP for 5 minutes
        Cache::put($otpKey, $otp, now()->addMinutes(5));

        // Set cooldown for 30 seconds
        $cooldownSeconds = 30;
        Cache::put($cooldownUntilKey, now()->addSeconds($cooldownSeconds), now()->addSeconds($cooldownSeconds));

        // TODO: Integrate an SMS provider here (e.g., Twilio, MSG91, Nexmo).
        // For development, we log the OTP so you can see it in storage/logs/laravel.log
        Log::info("Customer OTP for {$phone}: {$otp}");

        // In local environment, you can return the OTP for easier testing
        $payload = [
            'success'     => true,
            'message'     => $action === 'resend' ? 'OTP resent successfully.' : 'OTP sent successfully.',
            'cooldown'    => $cooldownSeconds,
            'expires_in'  => 300, // seconds (5 minutes)
        ];

        if (app()->environment('local')) {
            $payload['debug_otp'] = $otp;
        }

        return response()->json($payload);
    }
}