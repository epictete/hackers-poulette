<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'external.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'john.laterre@gmail.com';
    $mail->Password   = $external;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('john.laterre@gmail.com', 'John');
    $mail->addAddress('ep1ctete@protonmail.com', 'ep1ctete');
    
    // Content
    $body = "
        <p>Hello!</p>
        <p>Thank you for reaching out to us.</p>
        <p>Your form was successfully submitted.</p>
        <p>We will get back to you as soon as possible.</p>
        <p>Take care.</p>
        <p></p>
        <p>Hacker's Poulette support team.</p>
    ";

    $mail->isHTML(true);
    $mail->Subject = 'Form submit';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
    $mail->send();

    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>