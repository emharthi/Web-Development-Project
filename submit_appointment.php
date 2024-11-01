<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Appointment</title>
</head>
<body>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Eyad5500";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS officeAppointments";
if ($conn->query($sql) === TRUE) {
    $conn->select_db("officeAppointments");

    // Create appointments table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(100) NOT NULL,
        doctor VARCHAR(100) NOT NULL,
        appointment_date DATETIME NOT NULL,
        session_duration VARCHAR(50) NOT NULL,
        hall VARCHAR(50) NOT NULL,
        notes TEXT
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}

// Process form data on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $doctor = $_POST['doctor'];
    $appointment_date = $_POST['appointment_date'];
    $session_duration = $_POST['session_duration'];
    $hall = $_POST['hall'];
    $notes = $_POST['notes'];

    // Get current date to block past bookings
    $current_date = new DateTime();
    $appointment_date_obj = new DateTime($appointment_date);

    // Restrict booking for past dates
    if ($appointment_date_obj < $current_date) {
        echo "Error: You cannot book an appointment in the past.";
        exit();
    }

    // Restrict booking during prohibited hours (12:00 AM - 7:59 AM)
    $appointment_hour = (int)$appointment_date_obj->format('H');
    if ($appointment_hour < 8) {
        echo "Error: Booking is not allowed between 12:00 AM and 7:59 AM.";
        exit();
    }

    // Restrict booking on weekends (Friday and Saturday)
    $appointment_day = $appointment_date_obj->format('l'); // Get the day name
    if ($appointment_day == "Friday" || $appointment_day == "Saturday") {
        echo "Error: Booking is not allowed on Fridays and Saturdays.";
        exit();
    }

    // Faculty schedule conflicts
    $doctor_schedules = [
        "Dr. Hasan Ruwaizq Rudeed Al-Hadhli" => [
            ["day" => "Sunday", "start" => 10, "end" => 12],
            ["day" => "Wednesday", "start" => 10, "end" => 12]
        ],
        "Dr. Ahmed Hasan Yahya Al-Hindi" => [
            ["day" => "Monday", "start" => 14, "end" => 16],
            ["day" => "Wednesday", "start" => 14, "end" => 16]
        ],
        "Dr. Mohammed Kamal Hasan Halwani" => [
            ["day" => "Sunday", "start" => 9, "end" => 11],
            ["day" => "Tuesday", "start" => 9, "end" => 11],
            ["day" => "Thursday", "start" => 9, "end" => 11]
        ],
        "Dr. Idrees Nasser Ali Al-Sulbi" => [
            ["day" => "Monday", "start" => 13, "end" => 15],
            ["day" => "Wednesday", "start" => 13, "end" => 15]
        ]
    ];

    if (isset($doctor_schedules[$doctor])) {
        foreach ($doctor_schedules[$doctor] as $schedule) {
            if ($appointment_day == $schedule['day'] &&
                $appointment_hour >= $schedule['start'] &&
                $appointment_hour < $schedule['end']) {
                echo "Error: The appointment conflicts with the professor's schedule.";
                exit();
            }
        }
    }

    // Check for conflicting student appointments (one-hour duration)
    $sql = "SELECT * FROM appointments WHERE doctor = '$doctor' AND 
            ABS(TIMESTAMPDIFF(HOUR, appointment_date, '$appointment_date')) < 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Error: This time slot is already booked by another student.";
        exit();
    }

    // Insert appointment into database if no conflicts
    $sql = "INSERT INTO appointments (student_name, doctor, appointment_date, session_duration, hall, notes)
            VALUES ('$student_name', '$doctor', '$appointment_date', '$session_duration', '$hall', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>
