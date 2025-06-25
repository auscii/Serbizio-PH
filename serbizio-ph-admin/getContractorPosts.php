<?php
$servername = "localhost";
$dbusername = "u851624587_serbiziouser1";
$dbpassword = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log('Connection failed: ' . $conn->connect_error);
    die(json_encode(array('status' => 'Connection failed', 'error' => $conn->connect_error)));
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Retrieve JSON input
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Log the raw input for debugging
error_log('Raw input received: ' . $inputJSON);

// Check if JSON input is valid
if (!$input || !isset($input['contractor_phone'])) {
    error_log('Invalid JSON input received: ' . $inputJSON);
    die(json_encode(array('status' => 'Invalid JSON input', 'input_received' => $inputJSON)));
}

$email = trim($input['contractor_phone']);
$response = array();

if (!empty($email)) {
    // Log the received email for debugging
    error_log("Received mobile: " . $email);

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM contractor_post WHERE contractor_phone = ?");
    if ($stmt === false) {
        error_log('Prepare failed: ' . $conn->error . ' - Mobile: ' . $email);
        die(json_encode(array('status' => 'Prepare failed', 'error' => $conn->error, 'contractor_phone' => $email)));
    }

    // Bind the email parameter
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        error_log("Number of posts found: " . count($response) . ' - Mobile: ' . $email);
    } else {
        error_log("No records found for the mobile: " . $email);
        $response['status'] = 'No records found';
    }
    $stmt->close();
} else {
    error_log('Invalid mobile number: ' . $email);
    $response['status'] = 'Invalid mobile number';
}

$conn->close();

// Return JSON response
echo json_encode($response);
?>
