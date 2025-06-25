<?php
// update_contractor_profile.php

// Database connection setup
$servername = "localhost"; 
$dbusername = "u851624587_serbiziouser1"; 
$dbpassword = "Csvtech1"; 
$dbname = "u851624587_serbiziodb1"; 

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['contractor_email'], FILTER_SANITIZE_EMAIL);
    $name = filter_var($_POST['contractor_name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['contractor_phone'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['contractor_address'], FILTER_SANITIZE_STRING);
    $job_position = filter_var($_POST['job_position'], FILTER_SANITIZE_STRING);
    $job_description = filter_var($_POST['job_description'], FILTER_SANITIZE_STRING);
    $agency_name = filter_var($_POST['agency_name'], FILTER_SANITIZE_STRING);
    $account_number = filter_var($_POST['account_number'], FILTER_SANITIZE_STRING);
    $payment_channel = filter_var($_POST['payment_channel'], FILTER_SANITIZE_STRING);

    // Initialize profile image variable
    $photo = '';

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        $fileTmpName = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file extension
        if (in_array($fileExt, $allowedExts)) {
            // Sanitize file name and prevent overwriting
            $fileName = preg_replace('/[^a-zA-Z0-9\_\-\.]/', '', $fileName);
            $filePath = 'uploads/' . uniqid() . '_' . $fileName; // Prefix with a unique ID

            // Ensure uploads directory exists
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            // Move uploaded file to the uploads directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $photo = $filePath;
            } else {
                echo json_encode(['error' => 'Failed to upload file']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }
    }

    // Update contractor profile in the database
    $sql = "UPDATE contractors SET contractor_name = ?, contractor_email = ?, contractor_address = ?, photo = ?, job_position = ?, job_description = ?, agency_name = ?, account_number = ?, payment_channel = ? WHERE contractor_phone = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Database prepare statement failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('ssssssssss', $name, $email, $address, $photo, $job_position, $job_description, $agency_name, $account_number, $payment_channel, $phone);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Database query execution failed: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
