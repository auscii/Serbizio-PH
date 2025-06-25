<?php
header('Content-Type: application/json');

// Connect to your database
$mysqli = new mysqli('localhost', 'u851624587_serbiziouser1', 'Csvtech1', 'u851624587_serbiziodb1');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['mobile_num'] ?? '';

if (empty($email)) {
    echo json_encode(['error' => 'Mobile Number is required']);
    exit;
}

// Query the database
$sql = "SELECT name FROM users WHERE mobile_num = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();

$response = [];

if ($name) {
    $response['name'] = $name;
} else {
    $response['status'] = 'No records found';
}

echo json_encode($response);

$stmt->close();
$mysqli->close();
?>
