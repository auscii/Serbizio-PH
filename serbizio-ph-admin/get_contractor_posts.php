<?php
$servername = "localhost";
$dbusername = "u851624587_serbiziouser1";
$dbpassword = "Csvtech1";
$dbname = "u851624587_serbiziodb1";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch contractor posts with the necessary details
$sql = "SELECT service_name, provider_name, agency_name, details, amount, duration, category, image_url, email, contractor_phone FROM contractor_post ORDER BY timestamp DESC";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response['status'] = 'No records found';
}

$conn->close();

// Return JSON response
echo json_encode($response);
?>
