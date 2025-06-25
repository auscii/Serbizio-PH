<?php
// Database connection settings
$servername = "localhost"; // Replace with your server name
$dbusername = "u851624587_serbiziouser1";        // Replace with your database username
$dbpassword = "Csvtech1";            // Replace with your database password
$dbname = "u851624587_serbiziodb1";      // Replace with your database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Only handle POST requests
if ($requestMethod == 'POST') {
    // Retrieve POST data
    $email = $_POST['mobile_num'] ?? null;
    $title = $_POST['title'] ?? null;
    $message = $_POST['message'] ?? null;
    $date = $_POST['date'] ?? null;

    // Validate input data
    if (!$email || !$title || !$message || !$date) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Sanitize input to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $title = $conn->real_escape_string($title);
    $message = $conn->real_escape_string($message);
    $date = $conn->real_escape_string($date);

    // Insert notification into the database
    $sql = "INSERT INTO notifications (mobile_num, title, message, date) VALUES ('$email', '$title', '$message', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Notification added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding notification: ' . $conn->error]);
    }
} else {
    // Handle invalid request methods
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
