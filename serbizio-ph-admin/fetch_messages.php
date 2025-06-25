<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "u851624587_serbiziouser1";
$password = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sender and receiver from query parameters
$sender = $conn->real_escape_string($_GET['sender']);
$receiver = $conn->real_escape_string($_GET['receiver']);

// Fetch messages
$sql = "SELECT * FROM messages WHERE (sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender') ORDER BY timestamp ASC";
$result = $conn->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = array(
            'sender' => $row['sender'],
            'message' => $row['message'],
            'timestamp' => $row['timestamp'],
        );
    }
}

echo json_encode($messages);

$conn->close();
?>
