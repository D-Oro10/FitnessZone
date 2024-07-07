<?php
include 'DBconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentId = $_POST['paymentId'];

    // Update PaymentStatus in payment table to 'paid'
    $updatePaymentSql = "UPDATE payment SET PaymentStatus = 'paid', PaymentDate = NOW() WHERE PaymentID = $paymentId";
    
    if ($conn->query($updatePaymentSql) === TRUE) {
        echo "PaymentStatus in payment table updated successfully";
        
        // Get MemberID from the payment table
        $getMemberIdSql = "SELECT MemberID FROM payment WHERE PaymentID = $paymentId";
        $result = $conn->query($getMemberIdSql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $memberId = $row["MemberID"];

            // Check if all payments for the member are 'paid'
            $checkAllPaidSql = "SELECT COUNT(*) AS unpaidCount FROM payment WHERE MemberID = $memberId AND PaymentStatus = 'unpaid'";
            $result = $conn->query($checkAllPaidSql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $unpaidCount = $row['unpaidCount'];

                // Update PaymentStatus in members table based on the count of unpaid payments
                if ($unpaidCount == 0) {
                    $updateMemberSql = "UPDATE members SET PaymentStatus = 'paid' WHERE MemberID = $memberId";
                    if ($conn->query($updateMemberSql) === TRUE) {
                        echo "PaymentStatus in members table updated successfully";
                    } else {
                        echo "Error updating PaymentStatus in members table: " . $conn->error;
                    }
                }
            }
        }
    } else {
        echo "Error updating PaymentStatus in payment table: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
