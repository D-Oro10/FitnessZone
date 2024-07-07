<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include 'DBconnect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT * FROM payment WHERE PaymentStatus = 'unpaid'";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Output HTML table header
    echo "<table border='1'>
            <tr>
                <th>PaymentID</th>
                <th>MemberID</th>
                <th>PaymentAmount</th>
                <th>PaymentStatus</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["PaymentID"] . "</td>
                <td>" . $row["MemberID"] . "</td>
                <td>" . $row["PaymentAmount"] . "</td>
                <td id='paymentStatus" . $row["PaymentID"] . "'>" . $row["PaymentStatus"] . "</td>
                <td><button class='payButton' data-paymentid='" . $row["PaymentID"] . "'>Paid</button></td>
              </tr>";
    }

    // Close the table
    echo "</table>";
} else {
    echo "No results found";
}

// Close connection
$conn->close();
