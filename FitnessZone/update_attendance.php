<?php

$host = "localhost: 3306";
$username = "root";
$password = "";
$dbname = "dba_gym";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through the submitted data and update the database
    foreach ($_POST['attendance_code'] as $key => $value) {
        $appointmentID = $_POST['appointment_id'][$key];
        $attendanceCode = ($value == 'Y') ? 'Y' : 'N'; // Convert to 'Y' or 'N'

        // Update the database with the new attendance code
        $updateQuery = "UPDATE attendance SET AttendanceCode = '$attendanceCode' WHERE AppointmentID = $appointmentID";
        mysqli_query($conn, $updateQuery);
    }

    // Redirect back to the attendance page or any other appropriate location
    echo "<script>alert('Attendance updated successfully.');
        window.location.href = 'attendance.php';</script>";
    exit();
}

if (isset($_GET['delete_attendance'])) {
    $appointmentID = $_GET['delete_attendance'];

    // Delete the attendance from the attendance table
    $deleteAttendanceQuery = "DELETE FROM attendance WHERE AppointmentID='$appointmentID'";
    if (mysqli_query($conn, $deleteAttendanceQuery)) {
        // If the attendance is deleted successfully, proceed to delete the appointment
        $deleteAppointmentQuery = "DELETE FROM appointment WHERE AppointmentID='$appointmentID'";
        if (mysqli_query($conn, $deleteAppointmentQuery)) {
            echo "<script>alert('Attendance and appointment deleted successfully.');
            window.location.href = 'attendance.php';</script>";
        } else {
            echo "<script>alert('Error deleting appointment: " . mysqli_error($conn) . "');
            window.location.href = 'attendance.php';</script>";
        }
    } else {
        echo "<script>alert('Error deleting attendance: " . mysqli_error($conn) . "');
        window.location.href = 'attendance.php';</script>";
    }
}

/*
if (isset($_GET['delete_attendance'])) {
    $appointmentID = $_GET['delete_attendance'];

    // Delete the attendance from the database
    $sql = "DELETE FROM attendance WHERE AppointmentID='$appointmentID'";
    $sql = "DELETE FROM appointment WHERE AppointmentID='$appointmentID'";


    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Attendance deleted successfully.');
        window.location.href = 'attendance.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');
        window.location.href = 'attendance.php';</script>";
    }
} */
 // Close the database connection
 mysqli_close($conn);

?>
