<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "concert_ticketing_system";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$username = $_POST['username'];
$password = $_POST['password'];

// Query user table
$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows == 1) {
    // Valid login
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    header("Location: main.php"); // redirect to main page
    exit();
} else {
	header("Location: login.php?error=invalid");
	exit();
}

$conn->close();
?>
