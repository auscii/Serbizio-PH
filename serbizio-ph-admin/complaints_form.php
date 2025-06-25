<?php
// Include PHPMailer class files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include autoload.php (adjust the path based on your project structure)
require 'vendor/autoload.php'; 

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $complaint = htmlspecialchars($_POST['complaint']);
    
    // Generate a unique reference number
    $reference_number = uniqid('complaint_', true);
    
    // Send complaint to admin using PHPMailer
    $to = '21-0016c@sgen.edu.ph, serbiziosjc@gmail.com, csv2021tech@gmail.com';  // Add multiple email addresses here
    $subject = 'New Complaint Submission';

    // Construct the email message
    $email_message = "Reference Number: $reference_number\n";
    $email_message .= "Full Name: $full_name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Phone: $phone\n";
    $email_message .= "Complaint: $complaint\n";
    
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.com';                            // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                       // Enable SMTP authentication
        $mail->Username = 'no_reply@serbizio.com';                  // SMTP username
        $mail->Password = 'Csvtech1!';                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
        $mail->Port = 587;                                           // TCP port to connect to

        //Recipients
        $mail->setFrom('no_reply@serbizio.com', 'Serbizio');
        $mail->addAddress($to);                                      // Add multiple recipients

        // Content
        $mail->isHTML(false);                                         // Set email format to plain text
        $mail->Subject = $subject;
        $mail->Body    = $email_message;

        $mail->send();
        
        // Send the confirmation email to the user
        $user_subject = 'Complaint Received';
        $user_message = "Dear $full_name,\n\nThank you for submitting your complaint. We have received your complaint and will review it as soon as possible.\n\nHere are the details of your submission:\n\n";
        $user_message .= "Reference Number: $reference_number\n";
        $user_message .= "Full Name: $full_name\n";
        $user_message .= "Email: $email\n";
        $user_message .= "Phone: $phone\n";
        $user_message .= "Complaint: $complaint\n\n";
        $user_message .= "We will get back to you as soon as possible.\n\nBest regards,\nThe Serbizio Team";
        
        // Send the confirmation email using PHPMailer
        $mail->clearAddresses(); // Clear the previous recipient
        $mail->addAddress($email); // Add the user's email address
        $mail->Subject = $user_subject;
        $mail->Body    = $user_message;
        
        $mail->send();
        
        // Display a thank you message to the user
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Thank You</title>";
        echo "<style>
                body { font-family: Arial, sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f9ff; }
                .thank-you-message { text-align: justify-center; }
              </style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='thank-you-message'>";
        echo "<h1>We have received your complaint!</h1>";
        echo "<p>Dear $full_name,</p>";
        echo "<p>Thank you for submitting your complaint. We have received your complaint and will review it as soon as possible.</p>";
        echo "<p>Here are the details of your submission:</p>";
        echo "<ul>";
        echo "<li><strong>Reference Number:</strong> $reference_number</li>";
        echo "<li><strong>Full Name:</strong> $full_name</li>";
        echo "<li><strong>Email:</strong> $email</li>";
        echo "<li><strong>Phone:</strong> $phone</li>";
        echo "<li><strong>Complaint:</strong> $complaint</li>";
        echo "</ul>";
        echo "<p>We will get back to you as soon as possible.</p>";
        echo "<p>Best regards,<br>The Serbizio Team</p>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
        exit(); // Prevent further execution
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Complaint</title>
    <link rel="icon" href="assets/serbizio1.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f0f9ff;
            color: #333;
            text-align: center;
            padding: 40px;
            margin: 0;
        }
        h1 {
            margin-bottom: 20px;
            color: #3a7bd5;
        }
        form {
            display: block;
            background: white;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            margin: 0 auto; /* Center the form horizontally */
            transition: transform 0.3s;
        }
        form:hover {
            transform: scale(1.02); /* Slight zoom on hover */
        }
        input, textarea {
            margin-bottom: 20px;
            padding: 15px;
            font-size: 1em;
            border: 1px solid #a3c2f2;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus {
            border-color: #3a7bd5;
            outline: none;
        }
        button {
            padding: 15px;
            font-size: 1em;
            background-color: #3a7bd5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        button:hover {
            background-color: #2c6bd0;
            transform: translateY(-2px);
        }
        footer {
            margin-top: 20px;
            font-size: 0.9em;
        }
        footer .footer-links {
            margin-bottom: 10px;
        }
        footer .footer-links a {
            color: #3a7bd5;
            text-decoration: none;
            margin: 0 10px;
        }
        footer .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Submit a Complaint</h1>
    <form action="complaints_form.php" method="post">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="phone" placeholder="Your Phone Number" required>
        <textarea name="complaint" placeholder="Describe your complaint" rows="6" required></textarea>
        <button type="submit">Submit Complaint</button>
    </form>
    <footer>
        <div class="footer-links">
            <a href="index.php">Home</a> |
            <a href="privacy_policy.html">Privacy Policy</a> |
            <a href="cancellation_policy.html">Cancellation Policy</a> |
            <a href="terms_of_service.html">Terms of Service</a>
        </div>
        <p>&copy; 2024 Serbizio. All rights reserved.</p>
    </footer>
</body>
</html>
