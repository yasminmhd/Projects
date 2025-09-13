<?php
// DB connection
$host = "localhost";
$user = "root";
$password = "";
$database = "concert_ticketing_system";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

try {
    $stmt = $conn->prepare("INSERT INTO user (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $username, $password);
    $stmt->execute();

    // Success
	header("Location: signup.php?success=1");
	exit();
} catch (mysqli_sql_exception $e) {
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        header("Location: signup.php?error=exists");
    } else {
        header("Location: signup.php?error=other");
    }
    exit();
}

$conn->close();
?>
