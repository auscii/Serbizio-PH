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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $middle_name = htmlspecialchars(trim($_POST['middle_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $mobile_num = htmlspecialchars(trim($_POST['mobile_num']));
    $region = htmlspecialchars(trim($_POST['region']));
    $city = htmlspecialchars(trim($_POST['city']));
    $industry = htmlspecialchars(trim($_POST['industry']));
    $position = htmlspecialchars(trim($_POST['position']));

    // Validate mandatory fields
    if (empty($first_name) || empty($last_name) || empty($mobile_num) || empty($region) || empty($city) || empty($industry) || empty($position)) {
        $_SESSION['message'] = 'Please fill all required fields.';
        $_SESSION['message_type'] = 'error';
        header("Location: individual_form.php"); // Redirect to the signup form
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare to handle file uploads
    $uploads_dir = 'uploads'; // Directory to save uploaded files
    $profile_image = 'uploads/profile.webp'; // Default profile image
    $resume = '';
    $id_photo = '';

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $profile_image = uploadFile($_FILES['profile_image'], $uploads_dir);
    }

    // Handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $resume = uploadFile($_FILES['resume'], $uploads_dir);
    }

    // Handle ID photo upload
    if (isset($_FILES['id_photo']) && $_FILES['id_photo']['error'] == UPLOAD_ERR_OK) {
        $id_photo = uploadFile($_FILES['id_photo'], $uploads_dir);
    }

    // Prepare SQL query to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO individuals (first_name, middle_name, last_name, email, password, mobile_num, region, city, profile_image, resume, id_photo, industry, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $first_name, $middle_name, $last_name, $email, $hashed_password, $mobile_num, $region, $city, $profile_image, $resume, $id_photo, $industry, $position);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful!";

        // Send confirmation email to user using PHPMailer
try {
    // Check if the recipient email is valid and not empty
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Individual user has no email, cannot send email confirmation."; // Error message if email is invalid or empty
        header("Location: company_form.php"); // Replace with your actual form page URL
        exit();
    }

    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com'; // SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'no_reply@serbizio.com'; // SMTP username
    $mail->Password = 'Csvtech1!'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('no_reply@serbizio.com', 'Serbizio');
    $mail->addAddress($email, "$first_name $last_name"); // Add recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Registration Successful';
    $mail->Body = "Dear $first_name $last_name,<br><br>Thank you for registering!<br><br>You can download the mobile app from our download section:<br><br><a href='https://serbizio.com/#download-section'>Download Section</a><br><br>Best regards,<br>Serbizio Instant Services";

    // Send the email
    $mail->send();
} catch (Exception $e) {
    $_SESSION['error'] = "Error sending confirmation email: {$mail->ErrorInfo}";
    header("Location: individual_form.php"); // Replace with your actual form page URL
    exit();
}

        // Send notification email to admin about the new company registration using PHPMailer
        try {
            $mail = new PHPMailer(true);
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no_reply@serbizio.com';
            $mail->Password = 'Csvtech1!';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('no-reply@serbizio.com', 'Serbizio');
            $mail->addAddress('serbiziosjc@gmail.com'); // Admin email

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Service Provider Registration: $first_name $last_name";
            $mail->Body = "A new service provider has registered on Serbizio Instant Services:<br><br>
                           Full Name: $first_name $last_name<br>
                           Email: $email<br>
                           Mobile Number: $mobile_num<br>
                           Position: $position<br>
                           Industry: $industry<br>
                           Region: $region<br>
                           City: $city<br>
                           Profile Image: $profile_image<br><br>
                           Please review the new registration.";

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error sending admin notification email: {$mail->ErrorInfo}";
        }

    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();

    // Redirect to the form page to display the message
    header("Location: individual_form.php"); // Replace with your actual form page URL
    exit();
}

// Function to handle file uploads
function uploadFile($file, $upload_dir) {
    $tmp_name = $file['tmp_name'];
    $name = basename($file['name']);
    $upload_path = "$upload_dir/$name";

    // Move the file to the uploads directory
    if (move_uploaded_file($tmp_name, $upload_path)) {
        return $upload_path; // Return the file path
    } else {
        return ''; // Return empty string if upload fails
    }
}
?>
