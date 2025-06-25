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

// Check if the ID and status are passed
if (isset($_POST['id']) && isset($_POST['status']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the status
    $query = "UPDATE company_requests SET status = ? WHERE id = ?";

    if ($stmt = $mysqli->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param('si', $status, $id);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Request status updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error updating request status!";
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
    $_SESSION['message'] = "Invalid request data!";
    $_SESSION['message_type'] = "error";
}

// Redirect back to the manage requests page
header('Location: manage_requests.php');
exit();
?>
