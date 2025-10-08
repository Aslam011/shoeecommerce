<?php
$host = "localhost";     // your DB host
$user = "root";          // your DB username
$pass = "aslam117";              // your DB password
$db   = "shoecommerce";  // your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
