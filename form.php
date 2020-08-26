<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form submission</title>
</head>
<body>

<?php

$errors = array();

// 1. Sanitization
$options = array(
    'firstname' => FILTER_SANITIZE_STRING,
    'lastname' => FILTER_SANITIZE_STRING,
    'gender' => FILTER_SANITIZE_ENCODED,
    'email' => FILTER_SANITIZE_EMAIL,
    'country' => FILTER_SANITIZE_STRING,
    'subject' => FILTER_SANITIZE_STRING,
    'message' => FILTER_SANITIZE_STRING
);

$result = filter_input_array(INPUT_POST, $options);

// 2. Validation
if (!filter_var($result['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "The email address you entered seems to be invald. Please try again.";
}
 
// 3. Execution
// 3.1 Sanitization errors
if ($result != null AND $result != FALSE) {
    echo "<p>Form has been sanitized.</p>";
} else {
    echo "<p>A field is either empty or invalid!</p>";
    exit;
}

// 3.2 Validation errors
if (count($errors) > 0) {
    echo "<p>Oops!<br>  It looks like something didn't go as expected:</p>";
    print_r($errors);
    exit;
}

// 4. Execute
$form_content = "";
foreach($options as $key => $value) {
    $result[$key] = trim($result[$key]);
    $form_content .= "<p>" . $key . ': ' . $result[$key] . "</p>";
}

// 5. PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'john.laterre@gmail.com';
    $mail->Password   = 'Motive9!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('john.laterre@gmail.com', 'Hackers Poulette Support Team');
    $mail->addAddress($result['email'], $result['firstname']);
   
    // Content
    $body = "
        <p>Hello " . $result['firstname'] . "!</p>
        <p>Thank you for reaching out to us.</p>
        <p>Your form was successfully submitted.</p>
        <p>We will get back to you as soon as possible.</p>
        <p>Take care.</p>
        <br>
        <p><i>Hackers Poulette Support Team.</i></p>
        <br>
        <p><b>Here is a recap of your form:</b></p>
    ";

    $mail->isHTML(true);
    $mail->Subject = 'You contacted Hackers Poulette Support Team';
    $mail->Body    = $body . $form_content;
    $mail->AltBody = strip_tags($body);
    $mail->send();

    echo '
    <p>Your form was sent to <i>Hackers Poulette Support Team</i>.</p>
    <p>Thank you for contacting us.</p>
    ';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
   
</body>
</html>