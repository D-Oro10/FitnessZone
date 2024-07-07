<?php
$servername = "localhost:3307";
$username = "root";
$password = "ccis";
$dbname = "dba_gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get the equivalent number of days for FeeInterval
function getDaysEquivalent($feeInterval) {
    switch ($feeInterval) {
        case 'Daily':
            return 1;
        case 'Monthly':
            return 30;
        case '3 Months':
            return 90;
        case 'Annual':
            return 360;
        default:
            return 0; // Handle any other cases as needed
    }
}

// Query to get members with FeeInterval
$membersQuery = "SELECT MemberID, FeeInterval, MemberName, MembershipCode, PaymentStatus FROM members";
$membersResult = mysqli_query($conn, $membersQuery);

if (!$membersResult) {
    die('Error executing membersQuery: ' . mysqli_error($conn));
}

// Loop through members
while ($memberRow = mysqli_fetch_assoc($membersResult)) {
    $memberID = $memberRow['MemberID'];
    $feeInterval = $memberRow['FeeInterval'];
    $memberName = $memberRow['MemberName'];
    $membershipCode = $memberRow['MembershipCode'];
    $paymentStatus = $memberRow['PaymentStatus'];

    // Calculate the equivalent number of days
    $daysEquivalent = getDaysEquivalent($feeInterval);

    // Query to get the latest payment date
    $latestPaymentQuery = "SELECT MAX(PaymentDate) AS LatestPaymentDate FROM payment WHERE MemberID = $memberID";
    $latestPaymentResult = mysqli_query($conn, $latestPaymentQuery);

    if (!$latestPaymentResult) {
        die('Error executing latestPaymentQuery: ' . mysqli_error($conn));
    }

    $latestPaymentRow = mysqli_fetch_assoc($latestPaymentResult);
    $latestPaymentDate = $latestPaymentRow['LatestPaymentDate'];

    if ($latestPaymentDate !== null) {
        // Calculate the due date by adding the daysEquivalent
        $dueDate = date('Y-m-d', strtotime("$latestPaymentDate + $daysEquivalent days"));

        // Update PaymentStatus if dueDate is greater than or equal to the present date
        if (strtotime($dueDate) <= strtotime(date('Y-m-d'))) {
            $updatePaymentStatusQuery = "UPDATE members SET PaymentStatus = 'unpaid', due_date = '$dueDate' WHERE MemberID = $memberID AND (PaymentStatus != 'unpaid' OR due_date != '$dueDate')";
            $updatePaymentStatusResult = mysqli_query($conn, $updatePaymentStatusQuery);

            if (!$updatePaymentStatusResult) {
                die('Error executing updatePaymentStatusQuery: ' . mysqli_error($conn));
            }
        }
    }
}


$unpaidMembersQuery = "SELECT MemberID, MemberName, MembershipCode, FeeInterval FROM members WHERE PaymentStatus = 'unpaid'";
$unpaidMembersResult = mysqli_query($conn, $unpaidMembersQuery);

if (!$unpaidMembersResult) {
    die('Error executing unpaidMembersQuery: ' . mysqli_error($conn));
}

// Loop through members with unpaid PaymentStatus
while ($unpaidMemberRow = mysqli_fetch_assoc($unpaidMembersResult)) {
    $memberID = $unpaidMemberRow['MemberID'];
    $memberName = $unpaidMemberRow['MemberName'];
    $membershipCode = $unpaidMemberRow['MembershipCode'];
    $feeInterval = $unpaidMemberRow['FeeInterval'];

    // Query to get GymFee from price table
    $getGymFeeQuery = "SELECT GymFee FROM price WHERE MembershipCode = '$membershipCode' AND FeeInterval = '$feeInterval'";
    $getGymFeeResult = mysqli_query($conn, $getGymFeeQuery);

    if (!$getGymFeeResult) {
        die('Error executing getGymFeeQuery: ' . mysqli_error($conn));
    }

    $gymFeeRow = mysqli_fetch_assoc($getGymFeeResult);
    $gymFee = $gymFeeRow['GymFee'];

    // Determine MembershipType
    $membershipType = ($membershipCode == 'M') ? 'Member' : 'Student';

    // Check if the due_date is not equal to pending_payment due_date
    $checkPendingPaymentDueDateQuery = "SELECT * FROM pending_payment WHERE MemberName = '$memberName' AND due_date = CURRENT_DATE()";
    $checkPendingPaymentDueDateResult = mysqli_query($conn, $checkPendingPaymentDueDateQuery);

    if (!$checkPendingPaymentDueDateResult) {
        die('Error executing checkPendingPaymentDueDateQuery: ' . mysqli_error($conn));
    }

    // If no record with the same due_date, insert into pending_payment
    if (mysqli_num_rows($checkPendingPaymentDueDateResult) == 0) {
        // Insert into pending_payment
        $insertPendingPaymentQuery = "INSERT INTO pending_payment (MemberName, MembershipType, FeeInterval, PaymentAmount, due_date) VALUES ('$memberName', '$membershipType', '$feeInterval', $gymFee, CURRENT_DATE())";
        $insertPendingPaymentResult = mysqli_query($conn, $insertPendingPaymentQuery);

        if (!$insertPendingPaymentResult) {
            die('Error executing insertPendingPaymentQuery: ' . mysqli_error($conn));
        }
    }
}

// Update members table due_date
$updateDueDateQuery = "UPDATE members SET due_date = CURRENT_DATE() WHERE PaymentStatus = 'unpaid'";
$updateDueDateResult = mysqli_query($conn, $updateDueDateQuery);

if (!$updateDueDateResult) {
    die('Error updating due_date: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);