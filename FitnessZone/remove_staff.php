<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


include 'DBconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you're sending the 'coachName' parameter via POST
    if (isset($_POST['coachName'])) {
        $coachName = $_POST['coachName'];

        // Sanitize the input to prevent SQL injection
        $coachName = mysqli_real_escape_string($conn, $coachName);

        // Formulate the SQL DELETE query
        $sql = "DELETE FROM coach WHERE CoachName = '$coachName'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request. 'coachName' parameter missing.";
    }
} else {
    echo "Invalid request method. Use POST.";
}

mysqli_close($conn);


