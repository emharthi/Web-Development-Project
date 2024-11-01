<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Eyad5500";
$dbname = "officeAppointments";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the appointment ID from the URL
$appointment_id = $_GET['id'];

// SQL query to delete the appointment
$sql = "DELETE FROM appointments WHERE id='$appointment_id'";

if ($conn->query($sql) === TRUE) {
    echo "Appointment deleted successfully!";
    header("Location: appointments.php"); // Redirect back to appointments page
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
 
</body>
</html>