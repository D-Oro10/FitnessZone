<?php

// MailHandler.php
require 'vendor/autoload.php';
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

// Function to send a confirmation email
function sendConfirmationEmail($Mfull_name, $M_email, $totalFee) {
    try {
        $gmailDsn = 'smtps://dospupians@gmail.com:kgiemwqfrytcnrga@smtp.gmail.com';
        $mailer = new Mailer(Transport::fromDsn($gmailDsn)); 
        
        $emailText = "Dear $Mfull_name,\n\nCongratulations! Your Fitness Zone Gym account has been successfully activated. We're thrilled to welcome you to our fitness community!\n\nAs a member, you now have access to our state-of-the-art facilities, experienced trainers, and a supportive environment to help you achieve your fitness goals.\n\nHere are some important details:\n- Total Fee Amount Paid: $totalFee\n- Membership Benefits: Access to gym, personalized training sessions, and exclusive member events.\n\nWe look forward to supporting you on your fitness journey and helping you lead a healthier lifestyle. If you have any questions or need assistance, feel free to reach out to our team.\n\nWelcome aboard, and let's make every workout count!\n\nBest regards,\nFitness Zone Gym Team";

        $email = (new Email())
            ->from('dospupians@gmail.com') 
            ->to($M_email)
            ->subject('Account Activation Confirmation - Welcome to Fitnezz Zone Gym')
            ->text($emailText); 

        $mailer->send($email);

        // Send a JSON response indicating success
        $response = ['success' => true, 'message' => 'Email sent successfully'];
        http_response_code(200);
    } catch (\Exception $e) {
        // Send a JSON response indicating failure
        $response = ['success' => false, 'error' => 'Failed to send email: ' . $e->getMessage()];
        http_response_code(500); // Internal Server Error
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
