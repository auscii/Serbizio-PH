<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $workers_needed = $_POST['workers_needed'];
    $budget_per_worker = (float) $_POST['budget_per_worker']; // Ensure it's treated as a decimal
    $start_date = $_POST['start_date'];

    // Validate data before inserting
    if (empty($title) || empty($description) || empty($workers_needed) || empty($budget_per_worker) || empty($start_date)) {
        $_SESSION['message'] = "All fields are required!";
        $_SESSION['message_type'] = "error";
        header('Location: add_post.php'); // Redirect back to the add post page
        exit();
    }

    // Prepare SQL query to insert the data into the database
    $query = "INSERT INTO job_openings (title, description, workers_needed, budget_per_worker, start_date) 
              VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param('ssids', $title, $description, $workers_needed, $budget_per_worker, $start_date);
        
        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Job post added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding job post!";
            $_SESSION['message_type'] = "error";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database error: Unable to prepare the statement.";
        $_SESSION['message_type'] = "error";
    }

    // Close the database connection
    $mysqli->close();

    // Redirect back to the manage job posts page
    header('Location: manage_posts.php');
    exit();
}
?>
