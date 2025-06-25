<?php
// Database connection
$servername = "localhost"; // Replace with your server name
$dbusername = "u851624587_serbiziouser1"; // Replace with your database username
$dbpassword = "Csvtech1"; // Replace with your database password
$dbname = "u851624587_serbiziodb1"; // Replace with your database name

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve booking details from the request
$bookingId = $_POST['booking_id'] ?? 'No Booking ID';
$bookedDate = $_POST['booked_date'] ?? 'No booked date';
$bookedTime = $_POST['booked_time'] ?? 'No booking time';
$serviceName = $_POST['service_booked'] ?? 'No service available';
$contractorName = $_POST['contractor_name'] ?? 'No provider name';
$clientName = $_POST['client_name'] ?? 'No name';
$duration = $_POST['length_of_service'] ?? 'No duration';
$serviceFee = $_POST['total_amount'] ?? 'No fees';
$serviceStatus = $_POST['service_status'] ?? 'pending';
$email = $_POST['mobile_num'] ?? 'No mobile number';
$contractorEmail = $_POST['contractor_mobile'] ?? 'No email address';

// SQL query to insert booking details into the database
$sql = "INSERT INTO tbl_bookings (booking_id, booked_date, booked_time, service_booked, contractor_name, client_name, length_of_service, total_amount, service_status, mobile_num, contractor_mobile)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $bookingId, $bookedDate, $bookedTime, $serviceName, $contractorName, $clientName, $duration, $serviceFee, $serviceStatus, $email, $contractorEmail);

if ($stmt->execute()) {
    // Success response
    echo json_encode(["status" => "success", "message" => "Booking confirmed successfully."]);
} else {
    // Error response
    echo json_encode(["status" => "error", "message" => "Error confirming booking: " . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
