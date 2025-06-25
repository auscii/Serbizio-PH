<?php
// individual_contractor_form.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $experience = htmlspecialchars($_POST['experience']);
    $phone = htmlspecialchars($_POST['phone']);

    // Handle file uploads
    $upload_dir = 'uploads/'; // Directory where files will be stored
    $errors = [];
    
    // Ensure upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Handle ID 1
    if (isset($_FILES['id1']) && $_FILES['id1']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['id1']['tmp_name'];
        $file_name = basename($_FILES['id1']['name']);
        $target_file = $upload_dir . 'id1_' . $file_name;
        if (!move_uploaded_file($tmp_name, $target_file)) {
            $errors[] = "Failed to upload ID 1.";
        }
    } else {
        $errors[] = "Error uploading ID 1.";
    }

    // Handle ID 2
    if (isset($_FILES['id2']) && $_FILES['id2']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['id2']['tmp_name'];
        $file_name = basename($_FILES['id2']['name']);
        $target_file = $upload_dir . 'id2_' . $file_name;
        if (!move_uploaded_file($tmp_name, $target_file)) {
            $errors[] = "Failed to upload ID 2.";
        }
    } else {
        $errors[] = "Error uploading ID 2.";
    }

    // Handle resume
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['resume']['tmp_name'];
        $file_name = basename($_FILES['resume']['name']);
        $target_file = $upload_dir . 'resume_' . $file_name;
        if (!move_uploaded_file($tmp_name, $target_file)) {
            $errors[] = "Failed to upload resume.";
        }
    } else {
        $errors[] = "Error uploading resume.";
    }

    // Check for errors
    if (empty($errors)) {
        // For demonstration, we'll just echo the values
        // In a real-world scenario, you would store this information in a database
        echo "<h1>Application Received</h1>";
        echo "<p>Name: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Experience: $experience</p>";
        echo "<p>Phone: $phone</p>";

        // Send auto-reply email
        $to = $email;
        $subject = "Application Received";
        $message = "Dear $name,\n\nThank you for your application. We have received your details and will get back to you soon.\n\nBest regards,\nSerbizio";
        $headers = "From: no-reply@serbizio.com";

        mail($to, $subject, $message, $headers);

        // Send notification to admin
        $admin_email = "21-0096c@sgen.edu.ph"; // Replace with your admin email address
        $admin_subject = "New Individual Contractor Application";
        $admin_message = "A new application has been received from:\n\nName: $name\nEmail: $email\nExperience: $experience\nPhone: $phone";
        mail($admin_email, $admin_subject, $admin_message, $headers);
    } else {
        // Display errors
        echo "<h1>Application Error</h1>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
} else {
    // Display the form
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Serbizio | Apply as Individual Contractor</title>
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
        <h1>Apply as an Individual Contractor</h1>
        <form action="individual_contractor_form.php" method="post" enctype="multipart/form-data">
   <p class="description">
            Please fill out the form below to apply as an individual contractor with Serbizio. 
            Provide your personal details, upload the required documents, and submit your application. 
            We will review your submission and get back to you shortly.
        </p>
        <br>
    <input type="text" id="name" name="name" placeholder="Your Name" required>
    
    
    <input type="email" id="email" name="email" placeholder="Your Email" required>
    
    
    <textarea id="experience" name="experience" placeholder="Briefly describe your experience" rows="4" required></textarea>
    
   
    <input type="text" id="phone" name="phone" placeholder="Your Mobile Number" required>
    
    <!-- File upload fields with labels and margin -->
    <label for="id1" class="upload-label">Upload Government ID 1</label>
    <input type="file" id="id1" name="id1" accept=".jpg,.jpeg,.png,.pdf" required>
    
    <label for="id2" class="upload-label">Upload Government ID 2</label>
    <input type="file" id="id2" name="id2" accept=".jpg,.jpeg,.png,.pdf" required>
    
    <label for="resume" class="upload-label">Upload Resume</label>
    <input type="file" id="resume" name="resume" accept=".pdf" required>
    
    <button type="submit">Submit Application</button>
</form>


        <br>
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
