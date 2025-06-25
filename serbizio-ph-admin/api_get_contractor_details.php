<?php
// api_get_contractor.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provider_name = $_POST['provider_name'];

    // Connect to the database
    $conn = new mysqli('localhost', 'u851624587_serbiziouser1', 'Csvtech1', 'u851624587_serbiziodb1');

    if ($conn->connect_error) {
        die(json_encode(['error' => 'Database connection failed']));
    }

    // Fetch contractor details
    $stmt = $conn->prepare('SELECT * FROM contractors WHERE contractor_name = ?');
    $stmt->bind_param('s', $provider_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $contractor = $result->fetch_assoc();
        echo json_encode(['contractor' => $contractor]);
    } else {
        echo json_encode(['error' => 'No contractor found']);
    }

    $stmt->close();
    $conn->close();
}
