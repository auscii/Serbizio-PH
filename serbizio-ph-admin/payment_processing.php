<?php
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
    $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : '';
    $reference_id = isset($_POST['reference_id']) ? $_POST['reference_id'] : '';
    $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : '';
    $payer_name = isset($_POST['payer_name']) ? $_POST['payer_name'] : '';
    $payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $email = isset($_POST['mobile_num']) ? $_POST['mobile_num'] : '';

    // Validate required fields
    if (empty($booking_id) || empty($payment_method) || empty($account_number) || empty($reference_id) || empty($payment_amount) || empty($payer_name) || empty($payment_date) || empty($status) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO payments (booking_id, payment_method, account_number, reference_id, payment_amount, payer_name, payment_date, status, mobile_num) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $booking_id, $payment_method, $account_number, $reference_id, $payment_amount, $payer_name, $payment_date, $status, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Payment details processed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to process payment details.']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
