<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booked Appointments</title>
    <link rel="stylesheet" href="style.css">
    <script src="nav.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        h1 {
            margin-top: 50px;
            text-align: center;
        }

        table {
            margin: 50px auto;
            width: 90%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        button.delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        button.delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="content">
        <h1>View Booked Appointments</h1>

        <table id="appointments-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Session Duration</th>
                    <th>Hall</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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

                // SQL query to retrieve appointments
                $sql = "SELECT * FROM appointments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output each appointment
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["student_name"] . "</td>
                                <td>" . $row["doctor"] . "</td>
                                <td>" . $row["appointment_date"] . "</td>
                                <td>" . $row["session_duration"] . "</td>
                                <td>" . $row["hall"] . "</td>
                                <td>" . $row["notes"] . "</td>
                                <td><button class='delete-btn' onclick='deleteAppointment(" . $row["id"] . ")'>Delete</button></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No appointments booked yet</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteAppointment(id) {
            if (confirm("Are you sure you want to delete this appointment?")) {
                window.location.href = "delete_appointment.php?id=" + id;
            }
        }
    </script>

</body>
</html>
