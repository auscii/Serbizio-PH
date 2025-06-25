<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "u851624587_serbiziouser1";
$password = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Get the email from the request
$email = isset($_GET['contractor_phone']) ? $_GET['contractor_phone'] : '';

// Validate the email
if (empty($email)) {
    echo json_encode(["error" => "Mobile Number is required."]);
    exit;
}

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "SELECT contractor_name, contractor_email, contractor_phone, contractor_address, job_position, job_description, photo, agency_name, account_number, payment_channel FROM contractors WHERE contractor_phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if a contractor is found
if ($result->num_rows > 0) {
    // Fetch the contractor details
    $contractor = $result->fetch_assoc();
    echo json_encode($contractor);
} else {
    echo json_encode(["error" => "No contractor found with the provided mobile number."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
