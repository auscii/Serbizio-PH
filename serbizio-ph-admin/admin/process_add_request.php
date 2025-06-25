<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $request_date = $_POST['request_date'];
    $company_name = $_POST['company_name'];
    $requested_by = $_POST['requested_by'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    // Ensure budget_allocation is treated as a decimal (float or double)
    $budget_allocation = (float) $_POST['budget_allocation'];

    // Prepare SQL query to insert the data
    $query = "INSERT INTO company_requests (request_date, company_name, requested_by, description, status, budget_allocation) 
              VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param('sssssd', $request_date, $company_name, $requested_by, $description, $status, $budget_allocation);
        
        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Company request added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding company request!";
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

    // Redirect back to the manage requests page
    header('Location: manage_requests.php');
    exit();
}
?>
