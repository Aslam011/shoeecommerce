<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmailOtpController extends Controller
{
    /**
     * Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address',
            ], 422);
        }

        $email = $request->email;

        // Check if email already exists in customers table
        $emailExists = DB::table('customers')->where('email', $email)->exists();
        
        if ($emailExists) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please login instead.',
            ], 422);
        }

        // Generate 6-digit OTP
        $otp = sprintf('%06d', rand(0, 999999));

        // Set expiry time (5 minutes from now)
        $expiresAt = Carbon::now()->addMinutes(5);

        // Delete old OTPs for this email
        DB::table('email_otps')->where('email', $email)->delete();

        // Insert new OTP
        DB::table('email_otps')->insert([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'is_verified' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send email
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your ShoeCommerce Verification Code');
            });

            // Check if email actually sent
            if (count(Mail::failures()) > 0) {
                throw new \Exception('Email sending failed');
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully! Check your email inbox.',
            ]);
        } catch (\Exception $e) {
            // If email sending fails, show OTP for testing only in debug mode
            $response = [
                'success' => true,
                'message' => 'OTP generated. If email not received, check spam folder.',
            ];
            
            // Only show debug OTP if in debug mode
            if (config('app.debug')) {
                $response['debug_otp'] = $otp;
                $response['error'] = $e->getMessage();
            }
            
            return response()->json($response);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
            ], 422);
        }

        $email = $request->email;
        $code = $request->code;

        // Get the latest OTP for this email
        $otpRecord = DB::table('email_otps')
            ->where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'success' => false,
                'message' => 'No OTP found. Please request a new one.',
            ], 404);
        }

        // Check if already verified
        if ($otpRecord->is_verified) {
            return response()->json([
                'success' => true,
                'message' => 'Email already verified',
            ]);
        }

        // Check if expired
        if (Carbon::parse($otpRecord->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 400);
        }

        // Check if OTP matches
        if ($code !== $otpRecord->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ], 400);
        }

        // Mark as verified
        DB::table('email_otps')
            ->where('id', $otpRecord->id)
            ->update(['is_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully',
        ]);
    }

    /**
     * Check if phone number is already registered
     */
    public function checkPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format',
            ], 422);
        }

        $phone = $request->phone;

        // Check if phone already exists in customers table
        $phoneExists = DB::table('customers')->where('phone', $phone)->exists();

        if ($phoneExists) {
            return response()->json([
                'success' => false,
                'message' => 'This phone number is already registered.',
                'available' => false,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Phone number available',
            'available' => true,
        ]);
    }
}
