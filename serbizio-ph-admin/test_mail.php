<?php
// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer

try {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    // Set up mailer to use SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com'; // SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'no_reply@serbizio.com'; // Your SMTP username
    $mail->Password = 'Csvtech1!'; // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set the sender's email address
    $mail->setFrom('no_reply@serbizio.com', 'Serbizio');

    // Add recipient email address (this is where the test email will be sent)
    $mail->addAddress('csv2021tech@gmail.com'); // Replace with your test email

    // Set email subject and body
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body = 'This is a test email sent using PHPMailer. If you received this, it means PHPMailer is working correctly.';

    // Send the email
    if($mail->send()) {
        echo "Test email sent successfully!";
    } else {
        echo "Error: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
