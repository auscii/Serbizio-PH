<?php
// Database configuration
$host = 'localhost';
$dbname = 'u851624587_serbiziodb1';
$dbusername = 'u851624587_serbiziouser1';
$dbpassword = 'Csvtech1';

// Create a connection to the MySQL database
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email from the request
$email = isset($_GET['mobile_num']) ? $_GET['mobile_num'] : '';

// Prepare and execute SQL query to fetch notifications for the specific email
$sql = $conn->prepare("SELECT title, message, date FROM notifications WHERE mobile_num = ? ORDER BY date DESC");
$sql->bind_param('s', $email);
$sql->execute();
$result = $sql->get_result();

$notifications = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $notifications[] = array(
            'title' => $row['title'],
            'message' => $row['message'],
            'date' => $row['date']
        );
    }
}

// Close the database connection
$conn->close();

// Return the notifications in JSON format
header('Content-Type: application/json');
echo json_encode($notifications);
?>
