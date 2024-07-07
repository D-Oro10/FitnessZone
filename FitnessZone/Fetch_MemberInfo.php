<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include 'DBconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a table named 'members'
$memberID = $_GET['memberID']; // You can use GET or POST based on your needs

$sql = "SELECT MemberID, MemberName, ContactNo, Address, City, PostCode, Birthdate, EContactPerson, EContactNo, RTC, MembershipCode, FeeInterval, MemberShipDate FROM members WHERE MemberID = $memberID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo json_encode($row);
} else {
    echo "No data found";
}

$conn->close();
