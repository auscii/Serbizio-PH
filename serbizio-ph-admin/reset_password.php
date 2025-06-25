<?php
$mobile_num = $_POST['mobile_num'];
$otp = $_POST['otp'];
$new_password = $_POST['new_password'];

// Database connection
$mysqli = new mysqli("localhost", "u851624587_serbiziouser1", "Csvtech1", "u851624587_serbiziodb1");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verify OTP
$query = "SELECT otp FROM otp_requests WHERE mobile_num = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $mobile_num);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['otp'] == $otp) {
        // OTP is valid, now reset the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the user table
        $update_query = "UPDATE users SET password = ? WHERE mobile_num = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param("ss", $hashed_password, $mobile_num);

        if ($update_stmt->execute()) {
            // Delete the OTP entry after successful password reset
            $delete_query = "DELETE FROM otp_requests WHERE mobile_num = ?";
            $delete_stmt = $mysqli->prepare($delete_query);
            $delete_stmt->bind_param("s", $mobile_num);
            $delete_stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'Password reset successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reset password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No OTP found for this mobile number.']);
}

$mysqli->close();
?>
