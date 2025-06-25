<?php
$servername = "localhost";
$username = "u851624587_serbiziouser1";
$password = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$mobile = $_POST['mobile_num'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE mobile_num = ?");
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Send successful response
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid mobile number or password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid mobile number or password"]);
}

$stmt->close();
$conn->close();
?>
