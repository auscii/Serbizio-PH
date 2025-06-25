<?php
header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$dbusername = "u851624587_serbiziouser1";
$dbpassword = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create a new connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['contractor_phone']) && isset($data['contractor_password'])) {
    $email = $data['contractor_phone'];
    $password = $data['contractor_password'];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM contractors WHERE contractor_phone = ? AND contractor_password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Login successful
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    } else {
        // Invalid email or password
        echo json_encode(["status" => "error", "message" => "Invalid mobile number or password"]);
    }

    $stmt->close();
} else {
    // Missing data
    echo json_encode(["status" => "error", "message" => "Missing mobile number or password"]);
}

$conn->close();
?>
