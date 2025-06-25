<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// Database configuration
$servername = "localhost"; // Change to your server name
$username = "u851624587_serbiziouser1";        // Change to your MySQL username
$password = "Csvtech1";            // Change to your MySQL password
$dbname = "u851624587_serbiziodb1"; // Change to your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $service_name = $_POST['service_name'];
    $provider_name = $_POST['provider_name'];
    $details = $_POST['details'];
    $amount = $_POST['amount'];
    $agency_name = $_POST['agency_name'];
    $duration = $_POST['duration'];
    $category = $_POST['category'];
    $mobile = $_POST['contractor_phone'];

    // Handle image upload
    // Handle image upload
if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];
    $image_type = $image['type'];

    // Print the image details for debugging
    error_log(print_r($image, true)); // Log the details to help debug

    if ($image_error === 0) {
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name_new = uniqid('', true) . "." . $image_ext;
        $image_destination = 'uploads/' . $image_name_new;

        // Move the uploaded image to the 'uploads' directory
        if (move_uploaded_file($image_tmp_name, $image_destination)) {
            $image_url = $image_destination;
            error_log("Image uploaded successfully to: $image_url"); // Log success message
        } else {
            echo json_encode(["error" => "Failed to move uploaded file to the uploads directory."]);
            exit();
        }
    } else {
        echo json_encode(["error" => "Error uploading image: " . $image_error]);
        exit();
    }
} else {
    $image_url = null; // No image uploaded
}


    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO contractor_post (email, service_name, provider_name, details, amount, agency_name, duration, category, image_url, contractor_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $email, $service_name, $provider_name, $details, $amount, $agency_name, $duration, $category, $image_url, $mobile);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Post added successfully."]);
    } else {
        echo json_encode(["error" => "Failed to add post: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

$conn->close();
?>
