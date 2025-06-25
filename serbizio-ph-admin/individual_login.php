<?php
// Database connection
$servername = "localhost"; // Your server name (localhost or IP address)
$username = "u851624587_serbiziouser1";        // Your database username
$password = "Csvtech1";            // Your database password
$dbname = "u851624587_serbiziodb1"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data (mobile number and password)
$mobile_num = $_POST['mobile_num'];
$password = $_POST['password'];

// Validate input data
if (empty($mobile_num) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Mobile number or password cannot be empty."]);
    exit;
}

// Prepare the SQL query to fetch the user by mobile number
$sql = "SELECT * FROM individuals WHERE mobile_num = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mobile_num); // "s" is for string (mobile_num)
$stmt->execute();
$result = $stmt->get_result();

// Check if the mobile number exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify password (assuming passwords are stored hashed)
    if (password_verify($password, $row['password'])) {
        // Successful login
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        // Invalid password
        echo json_encode(["success" => false, "message" => "Invalid password"]);
    }
} else {
    // No user found with that mobile number
    echo json_encode(["success" => false, "message" => "No user found with this mobile number"]);
}

// Close connection
$stmt->close();
$conn->close();
?>
