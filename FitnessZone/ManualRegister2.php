<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include 'DBconnect.php';

include 'DBconnect.php';
require 'vendor/autoload.php';
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;


error_reporting(E_ALL);
ini_set('display_errors', 1);

$lname = $_POST['m_lname'];
$fname = $_POST['m_fname'];
$mname = $_POST['m_mname'];

$Mfull_name = $fname . ' ' . $mname . ' ' . $lname;

$elname = $_POST['e_lname'];
$efname = $_POST['e_fname'];
$emname = $_POST['e_mname'];

$Efull_name = $efname . ' ' . $emname . ' ' . $elname;

$M_contact = $_POST['M_contact'];
$M_email = $_POST['M_Email'];
$homeadd = $_POST['homeadd'];
$Mcity = $_POST['Mcity'];
$Mpostcd = $_POST['Mpostcd'];
$MBday = $_POST['MBday'];
$E_contact = $_POST['E_contact'];
$user_nm = $_POST['username'];
$M_type = $_POST['M_Type'];
$p_type = $_POST['Pay_Type'];

if ($M_type == 'Member') {
    $M_type = 'M';
} else {
    $M_type = 'S';
}

$MuserName = $_POST['username'];
$Mpassword = $_POST['userpassword'];


$relation = $_POST['relation'];
$otherInput = isset($_POST['otherInput']) ? $_POST['otherInput'] : '';

if ($relation == 'Other') {
    $relation = $otherInput;
}

// ... (previous code)

$lastInsertedID = null;

// Check if the MemberID already exists in the members table
$stmtCheckMemberID = $conn->prepare("SELECT MAX(MemberID) FROM members");
$stmtCheckMemberID->execute();
$stmtCheckMemberID->bind_result($lastInsertedID);
$stmtCheckMemberID->fetch();
$stmtCheckMemberID->close();

$lastInsertedID++;

// Membership Fee
$stmtMembershipFee = $conn->prepare("SELECT MembershipFee FROM membership WHERE MembershipCode = ?");
$stmtMembershipFee->bind_param("s", $M_type);
$stmtMembershipFee->execute();
$stmtMembershipFee->bind_result($membershipFee);
$stmtMembershipFee->fetch();
$stmtMembershipFee->close();

// Subscription Fee
$stmtGymFee = $conn->prepare("SELECT GymFee FROM price WHERE MembershipCode = ? AND FeeInterval = ?");
$stmtGymFee->bind_param("ss", $M_type, $p_type);
$stmtGymFee->execute();
$stmtGymFee->bind_result($gymFee);
$stmtGymFee->fetch();
$stmtGymFee->close();

// Calculate Total Fee
$totalFee = $membershipFee + $gymFee;

// Start a transaction
$conn->begin_transaction();

try {
    // Insert into members table
    $stmtMembers = $conn->prepare("INSERT INTO members (
        MemberID, MemberName, ContactNo, Email, Address, City, PostCode, Birthdate,
        EContactPerson, EContactNo, RTC, MembershipCode, FeeInterval, PaymentStatus, MemberShipDate
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'unpaid', NOW())");

    $stmtMembers->bind_param("sssssssssssss", $lastInsertedID, $Mfull_name, $M_contact, $M_email, $homeadd, $Mcity, $Mpostcd, $MBday,
        $Efull_name, $E_contact, $relation, $M_type, $p_type);

    if ($stmtMembers->execute()) {
        echo "New record created successfully for members table";
    } else {
        throw new Exception("Error inserting into members table: " . $stmtMembers->error);
    }



    // Insert into login table
    $stmtLogin = $conn->prepare("INSERT INTO registered (MemberID, uname, password) VALUES (?, ?, ?)");

    $stmtLogin->bind_param("sss", $lastInsertedID, $MuserName, $Mpassword);

    if ($stmtLogin->execute()) {
        echo "New record created successfully for login table";
    } else {
        throw new Exception("Error inserting into login table: " . $stmtLogin->error);
    }

    $stmtLogin->close();

    // Insert Payment
    $stmtPayment = $conn->prepare("INSERT INTO payment (MemberID, PaymentAmount, PaymentStatus) 
                       VALUES (?, ?, 'unpaid')");
    $stmtPayment->bind_param("id", $lastInsertedID, $totalFee);

    if ($stmtPayment->execute()) {
        echo "Payment record created successfully";
    } else {
        throw new Exception("Error inserting into payment table: " . $stmtPayment->error);
    }

    $stmtPayment->close();

    // Commit the transaction if all queries succeed
    $conn->commit();

    echo "<script>alert('Registration successful. Check your email for confirmation.');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    
    try {
        $gmailDsn = 'smtps://dospupians@gmail.com:kgiemwqfrytcnrga@smtp.gmail.com';
        $mailer = new Mailer(Transport::fromDsn($gmailDsn));

        $emailText = "Dear $Mfull_name," . PHP_EOL . PHP_EOL .
            "Congratulations on activating your Fitness Zone Gym account! 🎉 Get ready for an amazing fitness experience with benefits like unlimited gym access, personalized training, and exclusive events." . PHP_EOL .
            "Our expert trainers and supportive community are here to help you on your journey." . PHP_EOL . PHP_EOL .
            "Please proceed to pay the corresponding membership fee and your chosen subscription fee" . PHP_EOL . PHP_EOL .
            "Total Fee Amount: $totalFee" . PHP_EOL . PHP_EOL .
            "Please find below the GCash details for payment:" . PHP_EOL .
            "GCash Number: 1234-5678-9012" . PHP_EOL .
            "Account Name: Fitness Zone Gym" . PHP_EOL . PHP_EOL .
            "Please ensure that you include your MemberID in the payment reference for proper identification." . PHP_EOL . PHP_EOL .
            "If you have any questions, feel free to reach out." . PHP_EOL . 
            "Welcome aboard, and let's make every workout count!" . PHP_EOL . PHP_EOL .
            "Best regards," . PHP_EOL .
            "Fitness Zone Gym Team";
        
        $email = (new Email())
            ->from('dospupians@gmail.com')
            ->to($M_email)
            ->subject('Account Registration Confirmation')
            ->text($emailText);

        $mailer->send($email);

        echo "Email sent successfully.";
        
        
        
    } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
        echo 'Failed to send email: ' . $e->getMessage();
    }

} catch (Exception $e) {
    // Rollback the transaction if there's any error
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}

// Close the database connection
$conn->close();


