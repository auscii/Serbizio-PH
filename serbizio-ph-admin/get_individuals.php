<?php
// Database connection
$servername = "localhost";  // Your server name (localhost or IP address)
$username = "u851624587_serbiziouser1";  // Your database username
$password = "Csvtech1";  // Your database password
$dbname = "u851624587_serbiziodb1";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // It's a good idea to return an error message in JSON format if there's a connection error
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to fetch individual data
$query = "SELECT first_name, last_name, city, position, profile_image FROM individuals"; // Include profile_image in the query

// Execute the query
$result = $conn->query($query);

// Check if the query returned any results
if ($result->num_rows > 0) {
    // Initialize an array to hold the individuals data
    $individuals = array();

    // Loop through the results and add them to the array
    while ($row = $result->fetch_assoc()) {
        $individual = array(
            "first_name" => $row['first_name'],
            "last_name" => $row['last_name'],
            "city" => $row['city'],
            "position" => $row['position'],
            "profile_image" => $row['profile_image'] // Add profile image URL
        );
        // Add each individual to the main array
        $individuals[] = $individual;
    }

    // Prepare the response with the individuals data
    $response = array(
        "success" => true,
        "individuals" => $individuals
    );

    // Send the JSON response
    echo json_encode($response);
} else {
    // If no data is found, return an empty array with a success status
    echo json_encode(array("success" => true, "individuals" => array()));
}
?>