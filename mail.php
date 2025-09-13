<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
function sendWelcomeEmail($userEmail, $userName) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lucy.gichu@strathmore.edu';
        $mail->Password   = 'vdvx wapn dcet ykxx';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('lucy.gichu@strathmore.edu', 'TaskApp Team');
        $mail->addAddress($userEmail, $userName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to TaskApp!';
        $mail->Body    = "
            <html>
            <head>
                <title>Welcome to TaskApp</title>
            </head>
            <body>
                <h1>Hello $userName,</h1>
                <p>Welcome to TaskApp!</p>
            </body>
            </html>
        ";
        $mail->AltBody = "Hello $userName,\n\nWelcome to TaskApp! I'm happy to have you!";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        return false;
    }
}

?>

