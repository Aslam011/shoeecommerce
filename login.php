 HEAD
<?php
// login.php
session_start();

$host = "localhost";
$user = "root";  
$pass = "aslam117";      
$db   = "shoecommerce";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone    = trim($_POST["phone"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, password FROM customers WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashedPassword);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["customer_id"] = $id;
            $_SESSION["customer_name"] = $name;
            header("Location: index.php"); // customer homepage
            exit;
        } else {
            $error = "Invalid phone or password.";
        }
    } else {
        $error = "Invalid phone or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ShoeCommerce — Login</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; }
    .container { max-width:400px; margin:80px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,.1); }
    h2 { text-align:center; margin-bottom:20px; }
    label { display:block; margin-top:12px; }
    input { width:100%; padding:10px; margin-top:6px; border:1px solid #ccc; border-radius:6px; }
    button { margin-top:18px; width:100%; padding:12px; border:none; border-radius:6px; background:#007bff; color:#fff; font-weight:bold; cursor:pointer; }
    button:hover { background:#0056b3; }
    .error { margin-top:10px; color:red; text-align:center; }
    .link { margin-top:14px; text-align:center; font-size:14px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Customer Login</h2>
    <?php if ($error): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required placeholder="you@example.com">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <button type="submit">Login</button>
    </form>
    <div class="link">
      <a href="register.php">Create an Account</a>
    </div>
  </div>
</body>
</html>

<?php
// login.php
session_start();

$host = "localhost";
$user = "root";  
$pass = "aslam117";      
$db   = "shoecommerce";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone    = trim($_POST["phone"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, password FROM customers WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashedPassword);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["customer_id"] = $id;
            $_SESSION["customer_name"] = $name;
            header("Location: index.php"); // customer homepage
            exit;
        } else {
            $error = "Invalid phone or password.";
        }
    } else {
        $error = "Invalid phone or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ShoeCommerce — Login</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; }
    .container { max-width:400px; margin:80px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,.1); }
    h2 { text-align:center; margin-bottom:20px; }
    label { display:block; margin-top:12px; }
    input { width:100%; padding:10px; margin-top:6px; border:1px solid #ccc; border-radius:6px; }
    button { margin-top:18px; width:100%; padding:12px; border:none; border-radius:6px; background:#007bff; color:#fff; font-weight:bold; cursor:pointer; }
    button:hover { background:#0056b3; }
    .error { margin-top:10px; color:red; text-align:center; }
    .link { margin-top:14px; text-align:center; font-size:14px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Customer Login</h2>
    <?php if ($error): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required placeholder="you@example.com">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <button type="submit">Login</button>
    </form>
    <div class="link">
      <a href="register.php">Create an Account</a>
    </div>
  </div>
</body>
</html>
 ae3509d26b152da62cc8c1f681d77d502539bbc1
