<?php
$mobile_num = $_POST['mobile_num'];

// Generate a random OTP
$otp = rand(100000, 999999);

// Store the OTP in the database (make sure your database connection is established)
$mysqli = new mysqli("localhost", "u851624587_serbiziouser1", "Csvtech1", "u851624587_serbiziodb1");

$query = "INSERT INTO otp_requests (mobile_num, otp, created_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE otp = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssi", $mobile_num, $otp, $otp);
$result = $stmt->execute();

if ($result) {
    // Here you would typically send the OTP via SMS.
    // For demonstration, we'll just return it in the response.
    echo json_encode(['status' => 'success', 'otp' => $otp]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP.']);
}

$mysqli->close();
?>
