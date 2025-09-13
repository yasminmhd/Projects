<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "concert_ticketing_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$category_key = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
$section = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';

if (!$category_key) {
    echo json_encode(['status' => 'error', 'message' => 'Category required']);
    exit;
}

// Map frontend keys to DB category names
$category_map = [
    "the_star_club" => "Star Club",
    "the_early_entry" => "Early Entry",
    "the_blur" => "The Blur",
    "cat_1_standing" => "CAT 1",
    "cat_2" => "CAT 2",
    "cat_3" => "CAT 3",
    "cat_4" => "CAT 4",
    "cat_5" => "CAT 5"
];

$category = isset($category_map[$category_key]) ? $category_map[$category_key] : $category_key;

// Build section condition, if section exists and not "-"
$sectionCondition = ($section && $section !== '-') ? "AND section = '$section'" : "";

$sql = "SELECT COUNT(*) as available_seats 
        FROM seat 
        WHERE category = '$category' 
          $sectionCondition
          AND availability = 1";

$result = $conn->query($sql);

if (!$result) {
    error_log("SQL error: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
if ($row === null) {
    error_log("No rows returned.");
    echo json_encode(['status' => 'error', 'message' => 'No data found']);
    $conn->close();
    exit;
}

$available = intval($row['available_seats']);
echo json_encode(['status' => 'success', 'available' => $available]);

$conn->close();
