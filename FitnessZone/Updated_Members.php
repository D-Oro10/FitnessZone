<?php

include 'DBconnect.php';
require_once 'vendor/autoload.php';
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getEmailText($Mfull_name) {
    return "Dear $Mfull_name," . PHP_EOL . PHP_EOL .
    "Congratulations on activating your Fitness Zone Gym account! 🎉 Get ready for an amazing fitness experience with benefits like unlimited gym access, personalized training, and exclusive events." . PHP_EOL .
    "Our expert trainers and supportive community are here to help you on your journey." . PHP_EOL . 
    "If you have any questions, feel free to reach out." . PHP_EOL . 
    "Welcome aboard, and let's make every workout count!" . PHP_EOL .
    "Best regards," . PHP_EOL .
    "Fitness Zone Gym Team";

}


// Function to send a confirmation email
function sendConfirmationEmail($Mfull_name, $M_email) {
    try {
        $response = sendEmail($Mfull_name, $M_email);
    } catch (\Exception $e) {
        // Log the error
        error_log('Error sending email: ' . $e->getMessage());

        // Send a JSON response indicating failure
        $response = ['success' => false, 'error' => 'Failed to send email'];
    }

    return $response;
}

// Function to send an email
function sendEmail($Mfull_name, $M_email) {
    $gmailDsn = 'smtps://dospupians@gmail.com:kgiemwqfrytcnrga@smtp.gmail.com';
    $mailer = new Mailer(Transport::fromDsn($gmailDsn));

    $emailText = getEmailText($Mfull_name);

    $email = (new Email())
        ->from('dospupians@gmail.com')
        ->to($M_email)
        ->subject('Account Activation Confirmation - Welcome to Fitnezz Zone Gym')
        ->text($emailText);

    $mailer->send($email);

    // Send a JSON response indicating success
    return [
        'success' => true,
        'message' => 'Email sent successfully',
        'memberName' => $Mfull_name,
        'memberEmail' => $M_email
    ];
}

$data = json_decode(file_get_contents("php://input"));

$memberID = $data->memberID;
$newStatus = $data->newStatus;

// Fetch data from the request table based on the MemberID
$selectQuery = "SELECT MemberName, ContactNo, Email, Address, City, PostCode, Birthdate, 
    EContactPerson, EContactNo, RTC, MembershipCode, FeeInterval, UserName, Password, MemberShipDate 
    FROM request WHERE MemberID = $memberID";

$result = $conn->query($selectQuery);

// Your response array
$response = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Insert data into members table
    $insertMembersQuery = "INSERT INTO members (
        MemberName, ContactNo, Email, Address, City, PostCode, Birthdate,
        EContactPerson, EContactNo, RTC, MembershipCode, FeeInterval, MemberShipDate, PaymentStatus
    ) VALUES (
        '{$row['MemberName']}', '{$row['ContactNo']}', '{$row['Email']}', '{$row['Address']}', '{$row['City']}', '{$row['PostCode']}', '{$row['Birthdate']}',
        '{$row['EContactPerson']}', '{$row['EContactNo']}', '{$row['RTC']}', '{$row['MembershipCode']}', '{$row['FeeInterval']}', '{$row['MemberShipDate']}', '$newStatus'
    )";

    if ($conn->query($insertMembersQuery) === TRUE) {
        // Retrieve the last inserted MemberID in the Members table
        $lastInsertedMemberID = $conn->insert_id;

        // Insert data into login table
        $insertLoginQuery = "INSERT INTO login (MemberID, UserName, Password) VALUES ('$lastInsertedMemberID', '{$row['UserName']}', '{$row['Password']}')";

        if ($conn->query($insertLoginQuery) === TRUE) {
            // Update the payment status in the request table
            $updateQuery = "UPDATE request SET PaymentStatus = '$newStatus' WHERE MemberID = $memberID";

            if ($conn->query($updateQuery) === TRUE) {
                // Check if the new status is 'paid'
                if ($newStatus === 'paid') {
                    // Retrieve data from pending_payment
                    $selectPendingPaymentQuery = "SELECT * FROM pending_payment WHERE MemberName = '{$row['MemberName']}'";
                    $resultPendingPayment = $conn->query($selectPendingPaymentQuery);

                    if ($resultPendingPayment->num_rows > 0) {
                        $rowPendingPayment = $resultPendingPayment->fetch_assoc();

                        // Insert data into payment table
                        $insertPaymentQuery = "INSERT INTO payment (MemberID, PaymentDate, PaymentAmount, PaymentMode) 
                            VALUES ('$lastInsertedMemberID', NOW(), '{$rowPendingPayment['PaymentAmount']}', 'online')";
                        
                        if ($conn->query($insertPaymentQuery) === TRUE) {
                            // Delete the record from pending_payment
                            $deletePendingPaymentQuery = "DELETE FROM pending_payment WHERE MemberName = '{$row['MemberName']}'";
                            if ($conn->query($deletePendingPaymentQuery) === TRUE) {
                                // Delete the record from request table
                                $deleteRequestQuery = "DELETE FROM request WHERE MemberID = $memberID";
                                if ($conn->query($deleteRequestQuery) === TRUE) {
                                    $response['success'] = true;
                                    $response['movedToMembers'] = true;
                                    $response['newStatus'] = $newStatus;
                                    // Send confirmation email
                                    $emailResponse = sendConfirmationEmail($row['MemberName'], $row['Email']);
                                    // Merge the email response into the main response
                                    $response = array_merge($response, $emailResponse);
                                } else {
                                    $response['success'] = false;
                                    $response['error'] = 'Error deleting from request: ' . $conn->error;
                                }
                            } else {
                                $response['success'] = false;
                                $response['error'] = 'Error deleting from pending_payment: ' . $conn->error;
                            }
                        } else {
                            $response['success'] = false;
                            $response['error'] = 'Error inserting into payment: ' . $conn->error;
                        }
                    } else {
                        $response['success'] = false;
                        $response['error'] = 'Error: No record found in pending_payment for MemberName ' . $row['MemberName'];
                    }
                } else {
                    $response['success'] = true;
                    $response['movedToMembers'] = false;
                    $response['newStatus'] = $newStatus;
                }
            } else {
                $response['success'] = false;
                $response['error'] = 'Error updating request: ' . $conn->error;
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'Error inserting into login: ' . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Error inserting into members: ' . $conn->error;
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Error: Member not found';
}

echo json_encode($response);

$conn->close();