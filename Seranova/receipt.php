<?php
session_start();

// Database connection parameters
$host = "localhost";
$db   = "concert_ticketing_system";
$user = "root";
$password = "";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get inputs (from POST or session or GET)
$artist_id = $_POST['artist_id'] ?? $_SESSION['artist_id'] ?? null;
$numPeople = (int)($_POST['numPeople'] ?? $_SESSION['numPeople'] ?? 1);
$sitTogether = $_POST['sitTogether'] ?? $_SESSION['sitTogether'] ?? 'no';
$user_id = $_SESSION['user_id'] ?? null;
$paymentMethod = $_POST['paymentMethod'] ?? 'Unknown';

// Validate essential inputs
if (!$artist_id || !$user_id) {
    die("Missing artist or user information. Please login and select a concert.");
}

// Store in session for persistence if needed
$_SESSION['artist_id'] = $artist_id;
$_SESSION['numPeople'] = $numPeople;
$_SESSION['sitTogether'] = $sitTogether;

// Fetch concert info
$stmt = $pdo->prepare("SELECT * FROM concert WHERE artist_id = ?");
$stmt->execute([$artist_id]);
$concert = $stmt->fetch();

if (!$concert) {
    die("Concert not found.");
}

// Fetch available seats
$stmt = $pdo->query("SELECT * FROM seat WHERE availability = 1 ORDER BY seat_id ASC");
$availableSeats = $stmt->fetchAll();

if (count($availableSeats) < $numPeople) {
    die("Not enough available seats.");
}

// Assign seats
$assignedSeats = [];

if ($sitTogether === "yes") {
 
    $sections = [];
    foreach ($availableSeats as $seat) {
        $sections[$seat['section']][] = $seat;
    }

    $foundSeats = false;
    foreach ($sections as $sectionSeats) {
        if (count($sectionSeats) >= $numPeople) {
            $assignedSeats = array_slice($sectionSeats, 0, $numPeople);
            $foundSeats = true;
            break;
        }
    }

    if (!$foundSeats) {
       
        $assignedSeats = array_slice($availableSeats, 0, $numPeople);
    }
} else {
   
    $assignedSeats = array_slice($availableSeats, 0, $numPeople);
}

// Insert receipts and mark seats as unavailable
$purchase_date = date('Y-m-d');
$status = 'Purchased';

$insertReceiptStmt = $pdo->prepare("INSERT INTO receipt (user_id, seat_id, artist_id, venue, purchase_date, paymentmethod, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$updateSeatStmt = $pdo->prepare("UPDATE seat SET availability = 1 WHERE seat_id = ?");

foreach ($assignedSeats as $seat) {
    $insertReceiptStmt->execute([
        $user_id,
        $seat['seat_id'],
        $artist_id,
        $concert['venue'],
        $purchase_date,
        $paymentMethod,
        $status
    ]);
    $updateSeatStmt->execute([$seat['seat_id']]);
}

// Generate tickets HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SERANOVA - Your Tickets</title>
<link rel="icon" href="images/logo.png" type="image/png" />
<style>
   
    body {
        font-family: Arial, sans-serif;
        background-color: #C9A9D7;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .button-container {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    #print-button,
    #back-button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #2D3E49;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    #print-button:hover,
    #back-button:hover {
        background-color: #1a2b34;
    }
    .info-message {
        text-align: center;
        color: #2D3E49;
        font-size: 18px;
        margin: 20px 0 30px;
        line-height: 1.5;
    }
    #ticket-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .ticket {
        display: flex;
        width: 800px;
        height: 300px;
        border: 2px solid #2D3E49;
        background-color: #fff;
    }
    .left-section {
        width: 40%;
        position: relative;
        overflow: hidden;
    }
    .left-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .right-section {
        width: 60%;
        display: flex;
        padding: 20px;
        box-sizing: border-box;
    }
    .right-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-right: 10px;
    }
    .event-title {
        font-size: 24px;
        font-weight: bold;
        color: #2D3E49;
    }
    .event-details {
        margin-top: 10px;
        color: #333;
    }
    .event-details div {
        margin: 5px 0;
    }
    .seat-info {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
    .seat-info div {
        text-align: center;
        color: #2D3E49;
    }
    .ticket-number {
        margin-top: 20px;
        color: #2D3E49;
    }
    .barcode-container {
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .barcode {
        width: 80px;
    }
    @media print {
        #print-button {
            display: none;
        }
        body {
            background-color: white;
        }
        #ticket-container {
            flex-direction: column;
            align-items: center;
        }
        .ticket {
            page-break-after: always;
        }
    }
</style>
</head>
<body>
    <div class="button-container">
        <button id="print-button" onclick="window.print()">Print Tickets</button>
        <button id="back-button" onclick="window.location.href='main.php'">Back to Main Page</button>
    </div>
    <p class="info-message">
        <b>Your tickets have been successfully generated and will be sent to your email shortly. <br>
        Thank you for your purchase and enjoy the concert!</b>
    </p>

    <div id="ticket-container">
        <?php foreach ($assignedSeats as $seat): 
            // Generate a random ticket number
            $ticketNum = random_int(100000000, 999999999);
            ?>
            <div class="ticket">
                <div class="left-section">
                    <img src="banner.jpg" alt="Concert" />
                </div>
                <div class="right-section">
                    <div class="right-content">
                        <div>
                            <div class="event-title"><?= htmlspecialchars($concert['artistname']) ?></div>
                            <div class="event-details">
                                <div><strong>Venue:</strong> <?= htmlspecialchars($concert['venue']) ?></div>
                                <div><strong>Date:</strong> <?= htmlspecialchars($concert['date']) ?></div>
                                <div><strong>Time:</strong> <?= htmlspecialchars($concert['time']) ?></div>
                            </div>
                            <div class="seat-info">
                                <div><strong>Category</strong><p><?= htmlspecialchars($seat['category']) ?></p></div>
                                <div><strong>Section</strong><p><?= htmlspecialchars($seat['section']) ?></p></div>
                                <div><strong>Seat</strong><p><?= htmlspecialchars($seat['seat_number']) ?></p></div>
                            </div>
                        </div>
                        <div class="ticket-number">
                            <strong>Ticket Number:</strong> <?= $ticketNum ?>
                        </div>
                    </div>
                    <div class="barcode-container">
                        <img src="images/barcode.jpg" alt="Barcode" class="barcode" />
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
