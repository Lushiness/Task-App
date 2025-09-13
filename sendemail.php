<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;           // Enable debug output (set to 0 to disable)
    $mail->isSMTP();                                 // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';            // Gmail SMTP server
    $mail->SMTPAuth   = true;                        // Enable SMTP authentication
    $mail->Username   = 'lucy.gichu@strathmore.edu'; // Your Gmail
    $mail->Password   = 'vdvx wapn dcet ykxx';       // App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encryption: SSL
    $mail->Port       = 465;                         // Port for SSL

    // Recipients
    $mail->setFrom('lucy.gichu@strathmore.edu', 'Mailer');
    $mail->addAddress('lucygichu12@gmail.com', 'Joy Mutinda');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'ICS 2.2B';
    $mail->Body    = 'THIS IS THE BODY OF THE HTML';

    $mail->send();
    echo "✅ Message sent successfully!";
} catch (Exception $e) {
    echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
}
