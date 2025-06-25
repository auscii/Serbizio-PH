<?php
// update_user_profile.php

// Database connection setup
$servername = "localhost"; // Replace with your server name
$dbusername = "u851624587_serbiziouser1"; // Replace with your database username
$dbpassword = "Csvtech1"; // Replace with your database password
$dbname = "u851624587_serbiziodb1"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['mobile_num'];
    $address = $_POST['address'];
    
    // Initialize profile image variable
    $profileImage = '';

    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $fileTmpName = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file extension
        if (in_array($fileExt, $allowedExts)) {
            // Sanitize file name
            $fileName = preg_replace('/[^a-zA-Z0-9\_\-\.]/', '', $fileName);
            $filePath = 'uploads/' . $fileName;

            // Move uploaded file to the uploads directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $profileImage = $filePath;
            } else {
                echo json_encode(['error' => 'Failed to upload file']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }
    }

    // Update user profile in the database
    $sql = "UPDATE users SET name = ?, mobile_num = ?, address = ?, profile_image = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Database prepare statement failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('sssss', $name, $phone, $address, $profileImage, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Database query execution failed: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
