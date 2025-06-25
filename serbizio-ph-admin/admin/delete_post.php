<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

// Check if the ID is passed and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL query to delete the record
    $query = "DELETE FROM job_openings WHERE id = ?";

    if ($stmt = $mysqli->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param('i', $id);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Request deleted successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting request!";
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
} else {
    $_SESSION['message'] = "Invalid request ID!";
    $_SESSION['message_type'] = "error";
}

// Redirect back to the manage requests page
header('Location: manage_posts.php');
exit();
?>
