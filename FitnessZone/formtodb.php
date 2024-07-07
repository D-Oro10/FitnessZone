<?php

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "dba_gym";

$MemberID = isset($_POST['MemberID']) ? $_POST['MemberID'] : null;
$ClassID = isset($_POST['ClassID']) ? $_POST['ClassID'] : null;
$CoachID = isset($_POST['CoachID']) ? $_POST['CoachID'] : null;
$Date = isset($_POST['dateInput'])? $_POST['dateInput'] : "";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Use prepared statement for the appointment table
    $appointment_sql = "INSERT INTO appointment (MemberID, ClassID, CoachID, Schedule) 
       VALUES ('$MemberID', '$ClassID', '$CoachID', '$Date')";
    $appointment_stmt = mysqli_prepare($conn, $appointment_sql);

    if (mysqli_stmt_execute($appointment_stmt)) {
        // Get the last inserted ID from the appointment table
        $AppointmentID = mysqli_insert_id($conn);

        // Use prepared statement for the attendance table
        $attendance_sql = "INSERT INTO attendance (AppointmentID, MemberID, Date) VALUES (?, ?, ?)";
        $attendance_stmt = mysqli_prepare($conn, $attendance_sql);

        // Bind parameters for the attendance statement
        mysqli_stmt_bind_param($attendance_stmt, "iis", $AppointmentID, $MemberID, $Date);

        // Execute the statement for the attendance table
        if (mysqli_stmt_execute($attendance_stmt)) {
            echo "<script>alert('Appointment added successfully.'); 
            window.location.href = 'home.html';</script>";
        
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); 
            window.location.href = 'home.html';</script>";
        }
    }
    mysqli_stmt_close($appointment_stmt);
}

mysqli_close($conn);
?>
