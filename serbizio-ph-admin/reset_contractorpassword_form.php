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

// Retrieve token from GET request
$token = $_GET['token'] ?? '';

if (empty($token)) {
    echo "Invalid or missing token.";
    exit;
}

// Check if token is valid and not expired
$query = "SELECT email FROM contractors WHERE reset_token = ? AND reset_token_expiry > NOW()";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Invalid or expired token.";
    exit;
}

$email = $result->fetch_assoc()['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'] ?? '';

    if (empty($new_password)) {
        echo "Please enter a new password.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the contractor_password and clear the reset token
        $query = "UPDATE contractors SET contractor_password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $hashed_password, $email);

        if ($stmt->execute()) {
            echo "Password has been updated successfully. You can now log in on the app.";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
} else {
    // Display the reset password form
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Serbizio</title>
    <link rel="icon" href="assets/logoserbizio.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="password"], input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="password"]:focus {
            border-color: #555;
            outline: none;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="container">
        <center><img src="assets/logoserbizio.png" width="150px;"></center>
        <h2>Reset Password</h2>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="submit" value="Reset Password">
        </form>
        <div class="message">
            <!-- Any error or success messages can go here -->
        </div>
    </div>
</body>
</html>

    <?php
}

$conn->close();
?>
