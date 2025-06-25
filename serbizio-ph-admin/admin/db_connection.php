<?php
$host = 'localhost'; // Database host
$db = 'u851624587_serbiziodb1'; // Database name
$user = 'u851624587_serbiziouser1'; // Database username
$pass = 'Csvtech1'; // Database password

// Create connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Check connection
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
?>
