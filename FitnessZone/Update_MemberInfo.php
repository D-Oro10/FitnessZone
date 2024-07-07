<?php

include 'DBconnect.php';
include 'DBconnect.php';
require 'vendor/autoload.php';
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Change the line where you get the memberID
if (isset($_POST['memberID'])) {
    // The memberID is set, proceed with the SQL query

    $memberID = $_POST['memberID']; // Move this line up to get the memberID from POST

    // Fetch the original FeeInterval and MembershipType from the database
    $originalDataStmt = $conn->prepare("SELECT FeeInterval, MembershipCode FROM member WHERE MemberID = ?");
    $originalDataStmt->bind_param("i", $memberID);
    $originalDataStmt->execute();
    $originalDataStmt->bind_result($feeIntervalFromDatabase, $originalMType);
    $originalDataStmt->fetch();
    $originalDataStmt->close();

    // Initialize $totalFee to 0
    $totalFee = 0;

    // Fetch the new MembershipFee based on the new MembershipType if it has changed
    if (isset($_POST['M_Type']) && $_POST['M_Type'] != $originalMType) {
        $stmtMembershipFee = $conn->prepare("SELECT MembershipFee FROM membership WHERE MembershipCode = ?");
        $stmtMembershipFee->bind_param("s", $_POST['M_Type']);
        $stmtMembershipFee->execute();
        $stmtMembershipFee->bind_result($membershipFee);
        $stmtMembershipFee->fetch();
        $stmtMembershipFee->close();

        $stmtGymFee = $conn->prepare("SELECT GymFee FROM price WHERE MembershipCode = ? AND FeeInterval = ?");
        $stmtGymFee->bind_param("ss", $_POST['M_Type'], $_POST['Pay_Type']);
        $stmtGymFee->execute();
        $stmtGymFee->bind_result($gymFee);
        $stmtGymFee->fetch();
        $stmtGymFee->close();

        // Calculate the new total fee
        $totalFee = $membershipFee + $gymFee;
    } else {
        // MembershipType hasn't changed, check if FeeInterval has changed
        if (isset($_POST['Pay_Type']) && $_POST['Pay_Type'] !== $feeIntervalFromDatabase) {
            $stmtGymFee = $conn->prepare("SELECT GymFee FROM price WHERE MembershipCode = ? AND FeeInterval = ?");
            $stmtGymFee->bind_param("ss", $originalMType, $_POST['Pay_Type']);
            $stmtGymFee->execute();
            $stmtGymFee->bind_result($gymFee);
            $stmtGymFee->fetch();
            $stmtGymFee->close();

            // Calculate the new total fee
            $totalFee = $gymFee;
        }
    }
    $M_fullname = $_POST['m_name'];
    $Efull_name = $_POST['e_name']; // Corrected variable name
    $M_contact = $_POST['M_contact'];
    $M_email = $_POST['M_Email'];
    $homeadd = $_POST['homeadd'];
    $Mcity = $_POST['Mcity'];
    $Mpostcd = $_POST['Mpostcd'];
    $MBday = $_POST['MBday'];
    $E_contact = $_POST['E_contact'];
    $M_type = isset($_POST['M_Type']) ? $_POST['M_Type'] : '';

    if ($M_type == 'Member') {
        $M_type_code = 'M';
    } else {
        $M_type_code = 'S';
    }

    $p_type = $_POST['Pay_Type'];

    $relation = $_POST['relation'];
    $otherInput = isset($_POST['otherInput']) ? $_POST['otherInput'] : '';

    if ($relation == 'Other') {
        $relation = $otherInput;
    }

    echo "Received data from the form:";
    var_dump($_POST);

    $stmt = $conn->prepare("UPDATE member SET
        ContactNo = ?,
        Email = ?,
        Address = ?,
        City = ?,
        PostCode = ?,
        Birthdate = ?,
        EContactPerson = ?,
        EContactNo = ?,
        RTC = ?,
        MembershipCode = ?,
        FeeInterval = ?
    WHERE MemberID = ?");

    $stmt->bind_param("sssssssssssi", $M_contact, $M_email, $homeadd, $Mcity, $Mpostcd, $MBday,
        $Efull_name, $E_contact, $relation, $M_type_code, $p_type, $memberID);

    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "Update successful. Rows affected: " . $stmt->affected_rows;

            // Check if the FeeInterval has changed
            if ((isset($_POST['M_Type']) && $_POST['M_Type'] != $originalMType) || (isset($_POST['Pay_Type']) && $_POST['Pay_Type'] !== $feeIntervalFromDatabase)) {
                // Insert a new record into the payment table
                $paymentStmt = $conn->prepare("INSERT INTO payment (MemberID, PaymentAmount, PaymentStatus) VALUES (?, ?, 'unpaid')");
                $paymentStmt->bind_param("sd", $memberID, $totalFee); // Corrected "ss" to "sd" for double
                if ($paymentStmt->execute()) {
                echo "Payment record inserted successfully.";

                $gmailDsn = 'smtps://dospupians@gmail.com:kgiemwqfrytcnrga@smtp.gmail.com';
                $mailer = new Mailer(Transport::fromDsn($gmailDsn)); 
            
                $emailText = "Dear $M_fullname," . PHP_EOL . PHP_EOL;
                $emailText .= "We are notified that you have made changes with your membership subscription." . PHP_EOL;
                $emailText .= "Please proceed to pay the corresponding membership fee and your chosen subscription fee." . PHP_EOL . PHP_EOL;
                $emailText .= "Total Fee Amount: $totalFee" . PHP_EOL . PHP_EOL;
                $emailText .= "Please find below the GCash details for payment:" . PHP_EOL;
                $emailText .= "GCash Number: 1234-5678-9012" . PHP_EOL;
                $emailText .= "Account Name: Fitness Zone Gym" . PHP_EOL . PHP_EOL;
                $emailText .= "Please ensure that you include your MemberID in the payment reference for proper identification." . PHP_EOL . PHP_EOL;
                $emailText .= "Best regards," . PHP_EOL;
                $emailText .= "Fitness Zone Gym Team";

            $email = (new Email())
                ->from('dospupians@gmail.com') 
                ->to($M_email)
                ->subject('Account Registration Confirmation')
                ->text($emailText); 

            $mailer->send($email);
                
                echo "Email sent to user.";
            } else {
                echo "Error inserting payment record: " . $paymentStmt->error;
                // Log the error, for example, you can use error_log function
                error_log("Error inserting payment record: " . $paymentStmt->error);
            }
            $paymentStmt->close();
        }
    } else {
        echo "No rows were updated";
        }
    } else {
        echo "Error updating member information: " . $stmt->error;
        // Log the error, for example, you can use error_log function
        error_log("Error updating member information: " . $stmt->error);
    }

    $stmt->close(); // Close the $stmt block here
} else {
    echo "MemberID not set. Cannot proceed with the update.";
}

$conn->close();
