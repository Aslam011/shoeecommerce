<?php
// verify_email_otp.php - Verify OTP entered by user

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
$code = isset($input['code']) ? trim($input['code']) : '';

// Validate inputs
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

if (empty($code) || !preg_match('/^\d{6}$/', $code)) {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP format']);
    exit;
}

// Check if OTP exists and is valid
$stmt = $conn->prepare("SELECT id, otp, expires_at, is_verified FROM email_otps WHERE email = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'No OTP found. Please request a new one.']);
    exit;
}

$row = $result->fetch_assoc();
$storedOtp = $row['otp'];
$expiresAt = $row['expires_at'];
$isVerified = $row['is_verified'];
$otpId = $row['id'];

// Check if already verified
if ($isVerified == 1) {
    echo json_encode(['success' => true, 'message' => 'Email already verified']);
    exit;
}

// Check if expired
if (strtotime($expiresAt) < time()) {
    echo json_encode(['success' => false, 'message' => 'OTP has expired. Please request a new one.']);
    exit;
}

// Check if OTP matches
if ($code !== $storedOtp) {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please try again.']);
    exit;
}

// Mark as verified
$updateStmt = $conn->prepare("UPDATE email_otps SET is_verified = 1 WHERE id = ?");
$updateStmt->bind_param("i", $otpId);
$updateStmt->execute();

echo json_encode([
    'success' => true, 
    'message' => 'Email verified successfully'
]);

$stmt->close();
$updateStmt->close();
$conn->close();
?>
