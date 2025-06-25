<?php

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $agency_name = htmlspecialchars($_POST['agency_name']);
    $contact_person = htmlspecialchars($_POST['contact_person']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    
    // Define recipient email (admin email or the one you want to receive the form submissions)
    $to = '21-0096c@sgen.edu.ph'; // Change this to your email address
    $subject = 'New Partnership Request';
    
    // Construct the email message
    $email_message = "Agency Name: $agency_name\n";
    $email_message .= "Contact Person: $contact_person\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Phone: $phone\n";
    $email_message .= "Message: $message\n";

    // Send the email to the recipient (admin)
    mail($to, $subject, $email_message);

    // Define the subject and message for the confirmation email
    $user_subject = 'Partnership Request Received';
    $user_message = "Dear $contact_person,\n\nThank you for reaching out to us. We have received your registration and will review it shortly.\n\nHere are the details of your request:\n\n";
    $user_message .= "Company Name: $agency_name\n";
    $user_message .= "Contact Person: $contact_person\n";
    $user_message .= "Email: $email\n";
    $user_message .= "Phone: $phone\n";
    $user_message .= "Message: $message\n\n";
    $user_message .= "We will get back to you as soon as possible.\n\nBest regards,\nThe Serbizio Team";
    
    // Send the no-reply confirmation email to the user
    $headers = 'From: no-reply@serbizio.com' . "\r\n";
    mail($email, $user_subject, $user_message, $headers);

    // Display a thank you message to the user
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Thank You</title>";
    echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";
    echo "</head>";
    echo "<body>";
    echo "<h1>Thank You for Your Registration Request!</h1>";
    echo "<p>Dear $contact_person,</p>";
    echo "<p>Thank you for reaching out to us. We have received your registration and will review it shortly.</p>";
    echo "<p>Here are the details of your request:</p>";
    echo "<ul>";
    echo "<li><strong>Company Name:</strong> $agency_name</li>";
    echo "<li><strong>Contact Person:</strong> $contact_person</li>";
    echo "<li><strong>Email:</strong> $email</li>";
    echo "<li><strong>Phone:</strong> $phone</li>";
    echo "<li><strong>Message:</strong> $message</li>";
    echo "</ul>";
    echo "<p>We will get back to you as soon as possible.</p>";
    echo "<p>Best regards,<br>The Serbizio Team</p>";
    echo "</body>";
    echo "</html>";
} else {
    // Display the form if not a POST request
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Serbizio | Register With Us</title>
        <link rel="icon" href="assets/logoserbizio.png" type="image/x-icon">
        <style>
            body {
                font-family: \'Roboto\', Arial, sans-serif;
                background-color: #f0f9ff;
                color: #333;
                text-align: center;
                padding: 40px;
            }
            form {
                display: block;
                background: white;
                border-radius: 15px;
                box-shadow: 0 6px 12px rgba(0,0,0,0.1);
                padding: 25px;
                width: 100%;
                max-width: 600px;
                box-sizing: border-box;
                margin: 0 auto; /* Center the form horizontally */
            }
            input, textarea {
                margin-bottom: 15px;
                padding: 15px;
                font-size: 1em;
                border: 1px solid #a3c2f2;
                border-radius: 8px;
                width: 100%;
                box-sizing: border-box;
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
            form label.upload-label {
                display: block;
                margin: 20px 0 5px; /* Adjust margin as needed */
                font-weight: bold;
            }
            form input[type="file"] {
                margin-bottom: 15px; /* Space below each file input */
            }
        </style>
    </head>
    <body>
        <h1>Register With Us</h1>
        <form action="partner_agency_form.php" method="post">
            <input type="text" name="agency_name" placeholder="Company Name" required>
            <input type="text" name="contact_person" placeholder="Contact Person" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="phone" placeholder="Your Phone or Mobile Number" required>
            <textarea name="message" placeholder="Message" rows="6" required></textarea>
            <button type="submit">Submit Request</button>
        </form>
        <br>
        <footer>
            <div class="footer-links">
        <a href="index.php">Home</a> |
        <a href="privacy_policy.html">Privacy Policy</a> |
        <a href="cancellation_policy.html">Cancellation Policy</a> |
        <a href="terms_of_service.html">Terms of Service</a> |
        <a href="complaints_form.php">Submit a Complaint</a> <!-- Add this line -->
    </div>
            <p>&copy; 2024 Serbizio. All rights reserved.</p>
        </footer>
    </body>
    </html>';
}
?>
