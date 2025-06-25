<?php
// Set headers for JSON output
header('Content-Type: application/json');

// Database credentials
$servername = "localhost";  // Change as necessary
$username = "u851624587_serbiziouser1";         // Change as necessary
$password = "Csvtech1";             // Change as necessary
$dbname = "u851624587_serbiziodb1";       // Change as necessary

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch job openings
$sql = "SELECT * FROM job_openings order by id desc";
$result = $conn->query($sql);

// Create an array to store job openings
$jobOpenings = array();

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Loop through each row
    while($row = $result->fetch_assoc()) {
        // Add job opening data to the array
        $jobOpenings[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'workers_needed' => $row['workers_needed'],
            'budget_per_worker' => $row['budget_per_worker'],
            'start_date' => $row['start_date']
        );
    }

    // Return the job openings in JSON format
    echo json_encode(array("job_openings" => $jobOpenings));
} else {
    // Return an empty array if no job openings are found
    echo json_encode(array("job_openings" => []));
}

// Close the database connection
$conn->close();
?>
