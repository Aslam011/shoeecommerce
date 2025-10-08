<?php
// register.php - User Registration with Email OTP Verification

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "shoecommerce";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$success = $error = "";

// Form submitted?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["fullName"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    
    // Server-side validation
    $errors = [];
    
    // Validate full name (only letters and spaces)
    if (empty($fullName) || !preg_match('/^[a-zA-Z\s]+$/', $fullName)) {
        $errors[] = "Full name can only contain letters and spaces.";
    }
    
    // Validate email format
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address format.";
    }
    
    // Validate phone (must be 10 digits starting with 6-9)
    if (empty($phone) || !preg_match('/^[6-9]\d{9}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits starting with 6, 7, 8, or 9.";
    }
    
    // Validate password
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    
    // Validate password confirmation
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }
    
    // Check if email OTP was verified
    $otpVerified = false;
    $otpCheck = $conn->prepare("SELECT is_verified FROM email_otps WHERE email = ? AND is_verified = 1 ORDER BY created_at DESC LIMIT 1");
    $otpCheck->bind_param("s", $email);
    $otpCheck->execute();
    $otpResult = $otpCheck->get_result();
    
    if ($otpResult->num_rows > 0) {
        $otpVerified = true;
    } else {
        $errors[] = "Email not verified. Please verify your email with OTP.";
    }
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();
    
    if ($checkEmail->num_rows > 0) {
        $errors[] = "This email is already registered!";
    }
    
    // Check if phone already exists
    $checkPhone = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $checkPhone->bind_param("s", $phone);
    $checkPhone->execute();
    $checkPhone->store_result();
    
    if ($checkPhone->num_rows > 0) {
        $errors[] = "This phone number is already registered!";
    }
    
    // If there are errors, display them
    if (!empty($errors)) {
        $error = implode("<br>", $errors);
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())");
        $stmt->bind_param("ssss", $fullName, $email, $phone, $hashedPassword);
        
        if ($stmt->execute()) {
            $success = "Account created successfully! Redirecting to login...";
            
            // Clean up used OTP
            $cleanupStmt = $conn->prepare("DELETE FROM email_otps WHERE email = ?");
            $cleanupStmt->bind_param("s", $email);
            $cleanupStmt->execute();
            
            // Redirect after 2 seconds
            header("refresh:2;url=login.php");
            exit;
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    $checkEmail->close();
    $checkPhone->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ShoeCommerce — Register</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #0a0f1d; 
      color: #e8eef6;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px 0;
    }
    .container { 
      max-width: 500px; 
      width: 100%;
      margin: 20px auto; 
      padding: 30px; 
      background: #16181d; 
      border-radius: 10px; 
      box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
    }
    h2 { 
      text-align: center; 
      margin-bottom: 25px; 
      color: #6aa3ff;
    }
    .alert {
      padding: 12px 15px;
      margin-bottom: 20px;
      border-radius: 6px;
      font-size: 14px;
    }
    .error { 
      background: rgba(255, 68, 68, 0.1);
      border: 1px solid #ff4444;
      color: #ff4444; 
    }
    .success { 
      background: rgba(26, 127, 55, 0.1);
      border: 1px solid #1a7f37;
      color: #1a7f37; 
    }
    .link { 
      margin-top: 20px; 
      text-align: center; 
      font-size: 14px; 
    }
    .link a {
      color: #6aa3ff;
      text-decoration: none;
    }
    .link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>🛍️ Registration Status</h2>

    <?php if ($error): ?>
      <div class="alert error"><?php echo $error; ?></div>
      <div class="link">
        <a href="register.html">← Go back to registration</a>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success"><?php echo $success; ?></div>
      <div class="link">
        <a href="login.php">Click here if not redirected</a>
      </div>
    <?php endif; ?>
    
    <?php if (!$error && !$success): ?>
      <div class="link">
        <a href="register.html">Go to registration page</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
