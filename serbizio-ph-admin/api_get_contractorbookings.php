<?php
header('Content-Type: application/json');

// Replace these with your database connection details
$host = 'localhost';
$dbname = 'u851624587_serbiziodb1';
$username = 'u851624587_serbiziouser1';
$password = 'Csvtech1';

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Retrieve email from POST request
$data = json_decode(file_get_contents('php://input'), true);
$email = isset($data['contractor_mobile']) ? $data['contractor_mobile'] : '';

if (empty($email)) {
    echo json_encode(['error' => 'Mobile Number is required']);
    exit;
}

// Prepare and execute the query
$stmt = $conn->prepare('SELECT id, service_booked, client_name, booked_date, booked_time,service_status, total_amount FROM tbl_bookings WHERE contractor_mobile = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(['bookings' => $bookings]);

$stmt->close();
$conn->close();
?>
