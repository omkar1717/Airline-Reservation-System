<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$dbname = "airline_booking"; 
$user = "postgres";          
$password = "1717"; 

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Fetch the latest booking (most recent entry)
$query = "SELECT * FROM tickets ORDER BY booking_time DESC LIMIT 1";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error fetching booking: " . pg_last_error());
}

$ticket = pg_fetch_assoc($result);

// Close connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('tcb.jpeg') no-repeat center center/cover;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .ticket {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
            text-align: center;
            width: 500px;
            border-left: 8px solid #f8b400;
        }
        h2 {
            font-size: 32px;
            color: #f8b400;
        }
        p {
            font-size: 22px;
            margin: 12px 0;
        }
        .home-btn {
            margin-top: 20px;
            padding: 15px 30px;
            background: #f8b400;
            color: black;
            border: none;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }
        .home-btn:hover {
            background: #d18b00;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h2>Booking Confirmation</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($ticket['name']); ?></p>
        <p><strong>Flight:</strong> <?php echo htmlspecialchars($ticket['flight']); ?></p>
        <p><strong>Passengers:</strong> <?php echo htmlspecialchars($ticket['passengers']); ?></p>
        <p><strong>Booking Time:</strong> <?php echo htmlspecialchars($ticket['booking_time']); ?></p>
        <a href="index.html" class="home-btn">Home</a>
    </div>
</body>
</html>
