<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = "localhost";
$dbname = "airline_booking";
$user = "postgres";
$password = "1717"; // Replace with your PostgreSQL password

// Establish database connection
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Retrieve user input from form
$departure = $_POST['departure'];
$destination = $_POST['destination'];
$date = $_POST['date'];

// Prepare SQL query to fetch matching flights
$query = "SELECT * FROM flights WHERE departure_airport = $1 AND arrival_airport = $2 AND departure_date = $3";
$result = pg_query_params($conn, $query, array($departure, $destination, $date));

if (!$result) {
    die("Error fetching flights: " . pg_last_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('sf.jpg') no-repeat center center/cover;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            background: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
            text-align: center;
            width: 90%;
            max-width: 700px;
        }
        h3 {
            font-size: 28px;
            color: #f8b400;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            font-size: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }
        th {
            background: rgba(255, 255, 255, 0.2);
            color: #f8b400;
        }
        .no-flights {
            color: red;
            font-weight: bold;
            font-size: 22px;
            margin-top: 15px;
        }
        .home-btn {
            margin-top: 15px;
            padding: 15px 30px;
            background: #f8b400;
            color: black;
            border: none;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-right: 10px;
        }
        .home-btn:hover {
            background: #d18b00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Search Results</h3>

        <?php if (pg_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>Flight Name</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <?php while ($row = pg_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['flight_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_airport']); ?></td>
                    <td><?php echo htmlspecialchars($row['arrival_airport']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-flights">No flights found for the selected route and date.</p>
        <?php } ?>
        
        <a href="search-flight.html" class="home-btn">Search Again</a>
        <a href="home.html" class="home-btn">Home</a>
    </div>
</body>
</html>

<?php
pg_close($conn);
?>
