<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost"; // Replace with your database server
$dbusername = "u851624587_serbiziouser1"; // Replace with your database username
$dbpassword = "Csvtech1"; // Replace with your database password
$dbname = "u851624587_serbiziodb1"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// Get email from POST request
$email = isset($_POST['mobile_num']) ? $conn->real_escape_string($_POST['mobile_num']) : '';

// Fetch bookings for the given email
$sql = "SELECT id, booking_id, contractor_name, service_booked, booked_date, booked_time, length_of_service, total_amount, service_status, contractor_rate 
        FROM tbl_bookings 
        WHERE mobile_num = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$bookings = array();

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Close connection
$stmt->close();
$conn->close();

// Return JSON response
echo json_encode(array("bookings" => $bookings));
?>
