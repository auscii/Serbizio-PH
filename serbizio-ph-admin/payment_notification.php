<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$dbusername = "u851624587_serbiziouser1";
$dbpassword = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create a connection to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the data from the POST request
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $email = isset($_POST['mobile_num']) ? $_POST['mobile_num'] : '';

    // Validate required fields
    if (empty($title) || empty($message) || empty($date) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO notifications (title, message, date, mobile_num) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $message, $date, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Notification saved successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save notification: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
