<?php

$host = "localhost: 3307";
$username = "root";
$password = "";
$dbname = "dba_gym";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted
    if (isset($_POST['attendance_code'])) {
        // Loop through the submitted attendance codes
        foreach ($_POST['attendance_code'] as $appointmentID => $attendanceCode) {
            // Sanitize input to prevent SQL injection
            $appointmentID = mysqli_real_escape_string($conn, $appointmentID);
            $attendanceCode = mysqli_real_escape_string($conn, $attendanceCode);

            // Update the database with the new attendance code
            $updateQuery = "UPDATE attendance SET AttendanceCode = '$attendanceCode' WHERE AppointmentID = '$appointmentID'";
            $result = mysqli_query($conn, $updateQuery);

            if (!$result) {
                die("Update failed: " . mysqli_error($conn));
            }
        }
    }
}
// Close the connection
mysqli_close($conn);

// Redirect back to the attendance page
header("Location: attendance.php");
exit();
?>
