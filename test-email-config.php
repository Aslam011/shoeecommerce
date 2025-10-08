<?php
// Test Email Configuration Script
// Run this to verify your email settings

echo "============================================\n";
echo "📧 EMAIL CONFIGURATION TEST\n";
echo "============================================\n\n";

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check mail configuration
echo "📋 Current Mail Configuration:\n";
echo "--------------------------------\n";
echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_PASSWORD: " . (config('mail.mailers.smtp.password') ? '***SET***' : 'NOT SET') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

// Check if encryption is set
if (empty(config('mail.mailers.smtp.encryption'))) {
    echo "⚠️  WARNING: MAIL_ENCRYPTION is EMPTY!\n";
    echo "   This must be 'tls' for Gmail to work.\n";
    echo "   Please add to .env: MAIL_ENCRYPTION=tls\n\n";
}

// Test email sending
echo "📧 Testing Email Send...\n";
echo "--------------------------------\n";

$testEmail = 'aslam.117y@gmail.com'; // User's test email
$otp = '123456';

try {
    Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('ShoeCommerce - Test Email OTP');
    });
    
    echo "✅ SUCCESS: Email command executed!\n";
    echo "📬 Check your inbox at: $testEmail\n";
    echo "📧 Also check SPAM/JUNK folder!\n";
    echo "\nIf you received the email, the system is working!\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), 'Connection') !== false) {
        echo "🔧 FIX: This is a connection error.\n";
        echo "   1. Make sure MAIL_ENCRYPTION=tls in .env\n";
        echo "   2. Run: php artisan config:clear\n";
        echo "   3. Check your internet connection\n";
    } elseif (strpos($e->getMessage(), 'authentication') !== false) {
        echo "🔧 FIX: Authentication failed.\n";
        echo "   1. Verify app password is correct\n";
        echo "   2. Make sure 2-Step Verification is ON\n";
        echo "   3. Regenerate app password from Google\n";
    } else {
        echo "Full error details:\n";
        echo $e->getTraceAsString() . "\n";
    }
}

echo "\n============================================\n";
echo "Next Steps:\n";
echo "1. Add MAIL_ENCRYPTION=tls to .env\n";
echo "2. Run: php artisan config:clear\n";
echo "3. Run this test again\n";
echo "============================================\n";
