<?php
session_start();

// Ensure the session is properly secured
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);

require 'db_connection.php'; // Include your database connection

$error_message = '';

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        // Prepare and execute the SQL statement
        if ($stmt = $mysqli->prepare('SELECT password FROM admins WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            // Check if the username exists in the database
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($stored_password);
                $stmt->fetch();

                // Debugging output
                // Uncomment these lines for debugging, but remove them in production
                // echo "Stored Password: $stored_password<br>";

                // Verify the password
                if ($password === $stored_password) {
                    // Password is correct, set session and redirect to dashboard
                    session_regenerate_id(true); // Regenerate session ID to prevent session fixation
                    $_SESSION['admin'] = $username;
                    header('Location: admin_dashboard.php');
                    exit();
                } else {
                    $error_message = "Invalid username or password.";
                }
            } else {
                $error_message = "Invalid username or password.";
            }

            $stmt->close();
        } else {
            $error_message = "Error preparing the SQL statement: " . $mysqli->error;
        }

        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio | Admin Login</title>
    <link rel="icon" href="../assets/serbizio1.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(to right, #a8c0ff, #3f72af);
            color: #333;
            text-align: center;
            padding: 0;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 350px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            box-sizing: border-box;
        }
        img.logo {
            width: 100px; /* Adjust the size of the logo as needed */
            margin-bottom: 20px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #3f72af;
        }
        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        input {
            margin-bottom: 15px;
            padding: 15px;
            font-size: 1em;
            border: 1px solid #d0e1ff;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #a8c0ff;
            outline: none;
        }
        button {
            padding: 15px;
            font-size: 1.1em;
            background: #a8c0ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
            width: 100%;
        }
        button:hover {
            background: #8aabf6;
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
        .error-message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../assets/serbizio1.png" alt="Serbizio Logo" class="logo">
        <h1>Admin Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php
        if (!empty($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
