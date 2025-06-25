<?php
session_start(); // Start the session

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
        header("Location: index.php");
        exit();
    }

    // Admin email addresses
    $admin_emails = "serbiziosjc@gmail.com, csv2021tech@gmail.com";
    $mail_subject = "Contact Form Submission: $subject";
    
    // Email body
    $mail_body = "You have received a new message from the contact form:\n\n" .
                 "Name: $name\n" .
                 "Email: $email\n" .
                 "Subject: $subject\n" .
                 "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

   // Send the email
if (mail($admin_emails, $mail_subject, $mail_body, $headers)) {
    // Set success message in session
    $_SESSION['success_message'] = "Thank you! Your message has been sent successfully. We will review your inquiry and get back to you within 24 to 48 hours.";
} else {
    // Set error message in session
    $_SESSION['error_message'] = "There was an error sending your message. Please ensure that your email address is correct and try again later. If the problem persists, feel free to reach out directly at our support email.";
    
    // Optionally log the error for debugging
    error_log("Email sending failed for: $email, Subject: $subject");
}

    // Redirect back to index.php
    header("Location: index.php");
    exit();
} else {
    // Redirect if accessed directly
    header("Location: index.php"); // Redirect to the main page
    exit();
}
?>
