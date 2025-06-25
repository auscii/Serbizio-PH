<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'u851624587_serbiziodb1';
$user = 'u851624587_serbiziouser1';
$pass = 'Csvtech1';

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$email = $_GET['mobile_num'];
if (empty($email)) {
    echo json_encode(['error' => 'No mobile parameter provided']);
    exit;
}

$stmt = $connection->prepare('SELECT * FROM users WHERE mobile_num = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$connection->close();
?>
