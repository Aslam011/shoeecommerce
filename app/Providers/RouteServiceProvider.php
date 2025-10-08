<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();
        parent::boot();
    }

    protected function configureRateLimiting(): void
    {
        // Custom limiter for OTP requests
        RateLimiter::for('otp', function (Request $request) {
            $phone = (string) $request->input('phone', $request->ip());

            // Allow up to 3 sends per minute per phone and 30 per minute per IP
            return [
                Limit::perMinute(3)->by('phone:'.$phone),
                Limit::perMinute(30)->by('ip:'.$request->ip()),
            ];
        });
    }
}