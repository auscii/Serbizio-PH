<?php
// Database configuration
$servername = "localhost";
$username = "u851624587_serbiziouser1"; // replace with your database username
$password = "Csvtech1"; // replace with your database password
$dbname = "u851624587_serbiziodb1"; // replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['new_status'])) {
    $booking_id = $conn->real_escape_string($data['id']);
    $new_status = $conn->real_escape_string($data['new_status']);

    // Update the booking status in the database
    $sql = "UPDATE tbl_bookings SET service_status = '$new_status' WHERE id = '$booking_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

// Close the database connection
$conn->close();
?>
