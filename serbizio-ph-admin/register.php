<?php
session_start(); // Start a session

// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer

// Database connection
$servername = "localhost"; // Your server name
$username = "u851624587_serbiziouser1"; // Your database username
$password = "Csvtech1"; // Your database password
$dbname = "u851624587_serbiziodb1"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form data to variables
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $middle_name = $conn->real_escape_string($_POST['middle_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $mobile_num = $conn->real_escape_string($_POST['mobile_num']);
    $region = $conn->real_escape_string($_POST['region']);
    $city = $conn->real_escape_string($_POST['city']);
    
    // Initialize profile_image with default value
    $profile_image = 'uploads/profile.webp'; // Set default profile image path

    // Handle file upload for profile image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Directory where images will be saved
        $image_name = basename($_FILES['profile_image']['name']);
        $target_file = $upload_dir . uniqid() . '-' . $image_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $profile_image = $conn->real_escape_string($target_file); // Store the uploaded file path
        } else {
            $_SESSION['error'] = "Error uploading file.";
        }
    }

    // Assign other form data to variables
    $industry = $conn->real_escape_string($_POST['industry']);
    $company_name = $conn->real_escape_string($_POST['company_name']);
    $position = $conn->real_escape_string($_POST['position']);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO companies (first_name, middle_name, last_name, email, password, mobile_num, region, city, profile_image, industry, company_name, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $first_name, $middle_name, $last_name, $email, $password, $mobile_num, $region, $city, $profile_image, $industry, $company_name, $position);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful!";

        // Send confirmation email to user
       try {
    // Check if the recipient email is valid and not empty
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Registered company has no email, cannot send email confirmation."; // Error message if email is invalid or empty
        header("Location: company_form.php"); // Replace with the actual page URL
        exit();
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com'; // Your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'no_reply@serbizio.com'; // Your SMTP username
    $mail->Password = 'Csvtech1!'; // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender's email
    $mail->setFrom('no_reply@serbizio.com', 'Serbizio');

    // Add recipient (user)
    $mail->addAddress($email);

    // Email subject and body
    $mail->Subject = "Registration Successful";
    $mail->Body = "Dear $first_name $last_name,\n\nThank you for registering!\n\nYou can download the mobile app from our download section:\n\nhttps://serbizio.com/#download-section\n\nBest regards,\nSerbizio Instant Services";

    // Send email
    $mail->send();
} catch (Exception $e) {
    // Capture any error during sending
    $_SESSION['error'] = "Error sending confirmation email: " . $mail->ErrorInfo;
    header("Location: company_form.php"); // Replace with your actual form page URL
    exit();
}

        // Send notification email to admin about the new company registration
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'no_reply@serbizio.com'; // Your SMTP username
            $mail->Password = 'Csvtech1!'; // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender's email
            $mail->setFrom('no_reply@serbizio.com', 'Serbizio');

            // Add recipients (admins)
            $admins = ['serbiziosjc@gmail.com', 'csv2021tech@gmail.com'];
            foreach ($admins as $admin_email) {
                $mail->addAddress($admin_email);
            }

            // Email subject and body
            $mail->Subject = "New Company Registration: $company_name";
            $mail->Body = "A new company has registered on Serbizio Instant Services:\n\n" .
                          "Company Name: $company_name\n" .
                          "Registered By: $first_name $middle_name $last_name\n" .
                          "Email: $email\n" .
                          "Mobile Number: $mobile_num\n" .
                          "Position: $position\n" .
                          "Industry: $industry\n" .
                          "Region: $region\n" .
                          "City: $city\n" .
                          "Profile Image: $profile_image\n\n" .
                          "Please review the new registration.";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error sending admin notification email: " . $mail->ErrorInfo;
        }

    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();

    // Redirect to the form page to display the message
    header("Location: company_form.php"); // Replace with your actual form page URL
    exit();
}
?>
