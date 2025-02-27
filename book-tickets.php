<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $flight = $_POST['flight'];
    $passengers = $_POST['passengers'];

    // Database connection details
    $host = "localhost";
    $dbname = "airline_booking"; 
    $user = "postgres";          
    $password = "1717"; 

    // Connect to PostgreSQL
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    // Insert into the database
    $query = "INSERT INTO tickets (name, flight, passengers) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($name, $flight, $passengers));

    if ($result) {
        echo "<script>alert('Ticket booked successfully!'); window.location.href='confirmation.php';</script>";
    } else {
        echo "Error: " . pg_last_error($conn);
    }

    // Close connection
    pg_close($conn);
}
?>
