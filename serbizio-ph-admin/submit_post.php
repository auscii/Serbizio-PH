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

// Retrieve POST data
$service_name = $_POST['service_name'];
$provider_name = $_POST['provider_name'];
$details = $_POST['details'];
$amount = $_POST['amount'];
$duration = $_POST['duration'];
$agency_name = $_POST['agency_name'];
$category = $_POST['category'];
$image_url = $_POST['image_url'];

// Validate duration and category
$valid_durations = ['fulltime', 'parttime', 'on call'];
$valid_categories = ['yaya', 'maid', 'driver', 'cook', 'elderly caregiver', 'labandera'];

if (!in_array($duration, $valid_durations) || !in_array($category, $valid_categories)) {
  echo "Invalid duration or category";
  exit();
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contractor_post (service_name, provider_name, details, amount, duration, agency_name, category, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdssss", $service_name, $provider_name, $details, $amount, $duration, $agency_name, $category, $image_url);

// Execute statement
if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
