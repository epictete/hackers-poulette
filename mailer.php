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
    $mail->Mailer     = "smtp";
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'john.laterre@gmail.com';
    $mail->Password   = $external;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('support@hackers-poulette.com', 'Hackers Poulette Support Team');
    $mail->addAddress('john.laterre@gmail.com', 'John');
    $mail->addAddress($email, $firstname);
    
    // Content
    $body = "
        <p>
            Hello " . $firstname . "!<br>
            Thank you for reaching out to us.<br>
            Your form was successfully submitted.<br>
            We will get back to you as soon as possible.<br>
            Take care.<br>
        </p>
        <p></p>
        <p><i>Hackers Poulette Support Team.</i></p><br>
        <p></p>
        <p>Here is a recap of your form:</p>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;First Name: " . $firstname . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Last Name: " . $lastname . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Gender: " . $gender . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Email address: " . $email . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Country: " . $country . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Subject: " . $subject . "<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Message: " . $message . "<br>
        </p>
    ";

    $mail->isHTML(true);
    $mail->Subject = 'Hackers Poulette Contact Form';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
    $mail->send();

    $email_sent = '
        <div class="alert alert-success" role="alert">
            Your message was sent successfully!<br>
            Thank you for contacting us.
        </div>
    ';
} catch (Exception $e) {
    $email_not_sent = '
        <div class="alert alert-danger" role="alert">
            Your message could not be sent.<br>
            Mailer Error: ' . $mail->ErrorInfo . '
        </div>
    ';
}

?>