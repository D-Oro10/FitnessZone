<?php

include 'DBconnect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST['m_lname'];
    $fname = $_POST['m_fname'];
    $mname = $_POST['m_mname'];
    $M_email = $_POST['M_Email'];

    $Mfull_name = $fname . ' ' . $mname . ' ' . $lname;

   // Check if the name and email combination exists in the members table
$checkCombinedQuery = "SELECT MemberName, Email FROM members WHERE MemberName = ? OR Email = ? 
                       UNION 
                       SELECT MemberName, Email FROM request WHERE MemberName = ? OR Email = ?";
                           
$stmtver = $conn->prepare($checkCombinedQuery);
$stmtver->bind_param("ssss", $Mfull_name, $M_email, $Mfull_name, $M_email);
$stmtver->execute();
$resultCombined = $stmtver->get_result();

if ($resultCombined->num_rows > 0) {
    echo 'exists';
} else {
    echo 'not_exists';
}
}
