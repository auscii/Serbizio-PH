<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$dbusername = "u851624587_serbiziouser1";
$dbpassword = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get and trim POST data
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$username = trim($_POST['username'] ?? '');
$name = trim($_POST['name'] ?? '');
$mobile_num = trim($_POST['mobile_num'] ?? '');
$address = trim($_POST['address'] ?? '');

// Log the incoming data
error_log('Email: ' . $email);
error_log('Username: ' . $username);
error_log('Name: ' . $name);
error_log('Mobile Number: ' . $mobile_num);
error_log('City: ' . $address);

// Validate required fields
if (empty($email) || empty($password) || empty($username) || empty($name) || empty($mobile_num)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the mobile number already exists
$checkMobileQuery = "SELECT mobile_num FROM users WHERE mobile_num = ?";
$stmt = $conn->prepare($checkMobileQuery);
$stmt->bind_param("s", $mobile_num);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Mobile number already exists
    $response['status'] = 'error';
    $response['message'] = 'Mobile number already exists. Please use a different number.';
} else {
    // Prepare insert query
    $insertQuery = "INSERT INTO users (email, password, username, name, mobile_num, address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt === false) {
        error_log('Prepare failed: ' . $conn->error); // Log preparation error
        die(json_encode(['status' => 'error', 'message' => 'Query preparation failed.']));
    }

    // Bind parameters
    $stmt->bind_param("ssssss", $email, $hashed_password, $username, $name, $mobile_num, $address);

    // Execute statement
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Your registration is successful';
    } else {
        error_log('Execute failed: ' . $stmt->error); // Log execution error
        $response['status'] = 'error';
        $response['message'] = 'Error registering user: ' . $stmt->error; // Include error details
    }
}

// Return response as JSON
echo json_encode($response);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
