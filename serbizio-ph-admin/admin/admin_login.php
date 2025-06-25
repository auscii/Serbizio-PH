<?php
session_start();



require 'db_connection.php'; // Include your database connection

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        echo "<p>Username and password are required.</p>";
    } else {
        // Prepare and execute the SQL statement
        if ($stmt = $mysqli->prepare('SELECT password FROM admins WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // Verify the password
            if ($stmt->num_rows === 1 && password_verify($password, $stored_password)) {
                // Password is correct, set session and redirect to dashboard
                session_regenerate_id(true); // Regenerate session ID to prevent session fixation
                $_SESSION['admin'] = $username;
                header('Location: admin_dashboard.php');
                exit();
            } else {
                // Invalid username or password
                echo "<p>Invalid username or password.</p>";
            }
            
            $stmt->close();
        } else {
            // SQL prepare error
            echo "<p>Error preparing the SQL statement.</p>";
        }

        $mysqli->close();
    }
}
?>