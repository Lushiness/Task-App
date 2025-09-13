<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

/**
 * Send a welcome email to a newly registered user
 * @param string $userEmail The email address of the user
 * @param string $userName The name of the user
 * @return bool True if email sent successfully, false otherwise
 */
function sendWelcomeEmail($userEmail, $userName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Disable debug output
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lucy.gichu@strathmore.edu'; // Your Gmail
        $mail->Password   = 'vdvx wapn dcet ykxx';       // App Password
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
                <p>Welcome to TaskApp! We're excited to have you on board.</p>
                <p>You can now start managing your tasks efficiently.</p>
                <p>If you have any questions, feel free to contact us.</p>
                <p>Best regards,<br>TaskApp Team</p>
            </body>
            </html>
        ";
        $mail->AltBody = "Hello $userName,\n\nWelcome to TaskApp! We're excited to have you on board.\n\nYou can now start managing your tasks efficiently.\n\nIf you have any questions, feel free to contact us.\n\nBest regards,\nTaskApp Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error or handle it
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Example usage (remove or comment out in production)
// sendWelcomeEmail('user@example.com', 'John Doe');
?>
