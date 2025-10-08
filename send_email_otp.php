<?php
// send_email_otp.php - Send OTP to user's email

header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "shoecommerce";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$email = isset($input['email']) ? trim($input['email']) : '';

// Validate email
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Generate 6-digit OTP
$otp = sprintf('%06d', rand(0, 999999));

// Set expiry time (5 minutes from now)
$expiresAt = date('Y-m-d H:i:s', time() + (5 * 60));

// Delete old OTPs for this email
$conn->query("DELETE FROM email_otps WHERE email = '$email'");

// Insert new OTP
$stmt = $conn->prepare("INSERT INTO email_otps (email, otp, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $otp, $expiresAt);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to generate OTP']);
    exit;
}

// Send email using mail() function
$subject = "Your ShoeCommerce Verification Code";
$message = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .otp-box { background: #f0f7ff; border: 2px dashed #0d6efd; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .otp-code { font-size: 32px; font-weight: bold; color: #0d6efd; letter-spacing: 5px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1 style='color: #0d6efd;'>ShoeCommerce</h1>
        </div>
        <p>Hello,</p>
        <p>Thank you for registering with ShoeCommerce! Please use the following One-Time Password (OTP) to verify your email address:</p>
        
        <div class='otp-box'>
            <div class='otp-code'>{$otp}</div>
        </div>
        
        <p><strong>This OTP is valid for 5 minutes.</strong></p>
        <p>If you didn't request this code, please ignore this email.</p>
        
        <div class='footer'>
            <p>&copy; " . date('Y') . " ShoeCommerce. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: ShoeCommerce <noreply@shoecommerce.com>" . "\r\n";

if (mail($email, $subject, $message, $headers)) {
    echo json_encode([
        'success' => true, 
        'message' => 'OTP sent successfully to your email',
        'debug_otp' => $otp  // Remove this in production!
    ]);
} else {
    // If mail() fails, still return success but log the OTP for testing
    echo json_encode([
        'success' => true, 
        'message' => 'OTP generated (Email sending may not be configured)',
        'debug_otp' => $otp  // For testing purposes - remove in production
    ]);
}

$stmt->close();
$conn->close();
?>
