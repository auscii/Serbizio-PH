<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

// Handle Add Contractor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_contractor'])) {
    $contractor_name = $_POST['contractor_name'] ?? '';
    $contractor_email = $_POST['contractor_email'] ?? '';
    $contractor_phone = $_POST['contractor_phone'] ?? '';
    $contractor_password = $_POST['contractor_password'] ?? '';
    $contractor_address = $_POST['contractor_address'] ?? '';
    $payment_channel = $_POST['payment_channel'] ?? '';
    $account_number = $_POST['account_number'] ?? '';

    // Validate inputs
    if (!empty($contractor_name) && !empty($contractor_email) && !empty($contractor_phone) && !empty($contractor_password) && !empty($contractor_address) && !empty($payment_channel) && !empty($account_number)) {
        // Check if email already exists
        $check_sql = "SELECT COUNT(*) FROM contractors WHERE contractor_email = ?";
        $check_stmt = $mysqli->prepare($check_sql);
        
        if ($check_stmt) {
            $check_stmt->bind_param('s', $contractor_email);
            $check_stmt->execute();
            $check_stmt->bind_result($email_count);
            $check_stmt->fetch();
            $check_stmt->close();
            
            if ($email_count > 0) {
                $_SESSION['message'] = "Email already exists.";
                $_SESSION['message_type'] = "error";
            } else {
                // Insert the contractor details without password hashing
                $sql = "INSERT INTO contractors (contractor_name, contractor_email, contractor_phone, contractor_password, contractor_address, payment_channel, account_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                
                if ($stmt) {
                    $stmt->bind_param('sssssss', $contractor_name, $contractor_email, $contractor_phone, $contractor_password, $contractor_address, $payment_channel, $account_number);
                    
                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Contractor added successfully.";
                        $_SESSION['message_type'] = "success";
                    } else {
                        $_SESSION['message'] = "Error executing statement: " . $stmt->error;
                        $_SESSION['message_type'] = "error";
                    }
                    $stmt->close();
                } else {
                    $_SESSION['message'] = "Error preparing statement: " . $mysqli->error;
                    $_SESSION['message_type'] = "error";
                }
            }
        } else {
            $_SESSION['message'] = "Error preparing check statement: " . $mysqli->error;
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Please fill in all required fields.";
        $_SESSION['message_type'] = "error";
    }
    
    header('Location: manage_contractors.php');
    exit();
}

// Handle Contractor Actions (Update/Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $contractor_id = $_POST['id'] ?? '';
    $action = $_POST['action'] ?? '';

    if (!empty($contractor_id) && !empty($action)) {
        if ($action === 'delete') {
            // Prepare and execute the delete query
            $sql = "DELETE FROM contractors WHERE id = ?";
            $stmt = $mysqli->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('i', $contractor_id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Contractor deleted successfully!';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Failed to delete contractor.';
                    $_SESSION['message_type'] = 'error';
                }
                $stmt->close();
            } else {
                $_SESSION['message'] = 'Error preparing statement: ' . $mysqli->error;
                $_SESSION['message_type'] = 'error';
            }
        } elseif ($action === 'update') {
            // Handle update functionality (requires more information about what to update)
            // Example: Update contractor status
            // $status = $_POST['status'] ?? '';
            // $sql = "UPDATE contractors SET status = ? WHERE id = ?";
            // $stmt = $mysqli->prepare($sql);
            // $stmt->bind_param('si', $status, $contractor_id);
            // $stmt->execute();
            // $_SESSION['message'] = 'Contractor updated successfully!';
        } else {
            $_SESSION['message'] = 'Invalid action.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Invalid contractor ID or action.';
        $_SESSION['message_type'] = 'error';
    }

    header('Location: manage_contractors.php');
    exit();
}

// Fetch contractors to display in the UI
$query = "SELECT * FROM contractors";
$result = $mysqli->query($query);

if ($result) {
    $contractors = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $contractors = [];
    echo "Error: " . $mysqli->error; // Debugging purposes
}

$mysqli->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio | Manage Contractors</title>
    <link rel="icon" href="../assets/serbizio1.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
     <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
               /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; /* Pastel blue background */
        }

        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #ffffff; /* White background */
            color: #007bff; /* Pastel blue text color */
            padding: 15px 20px;
            border-bottom: #d1e0e0 1px solid; /* Light pastel blue border */
            position: relative;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header h1 {
            margin: 0;
            color: #007bff; /* Pastel blue text color */
        }

        .menu-toggle {
            display: none; /* Hide the button by default */
            background-color: #007bff; /* Pastel blue button */
            color: white;
            border: none;
            padding: 10px;
            font-size: 24px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 1000; /* Ensure it's above other elements */
        }

        #nav-menu {
            display: flex;
        }

        #nav-menu a {
            color: #007bff; /* Pastel blue text color */
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }

        #nav-menu a:hover {
            background: #e0f4ff; /* Light pastel blue background on hover */
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            #nav-menu {
                display: none; /* Hide menu on small screens */
                float: none;
                width: 100%;
                text-align: center;
                position: absolute;
                top: 60px; /* Adjust to be below header */
                left: 0;
                background-color: #ffffff; /* White background for menu */
                border-bottom: #d1e0e0 1px solid; /* Light pastel blue border */
                flex-direction: column;
            }

            #nav-menu.show {
                display: flex; /* Show menu when toggled */
            }

            .menu-toggle {
                display: block; /* Show toggle button on small screens */
            }
        }

        .content {
            margin: 20px 0;
        }

        .card {
            background: #ffffff; /* White background for cards */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            text-align: center;
            flex: 1;
            min-width: 200px;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .complaints-list {
            margin: 20px 0;
        }

        .complaints-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .complaints-list th, .complaints-list td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .complaints-list th {
            background-color: #007bff; /* Pastel blue background */
            color: white;
        }

        .form-container {
            margin: 20px 0;
        }

        .form-container form {
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-container input[type="text"], 
        .form-container textarea,
        .form-container select {
            width: 80%;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .form-container textarea {
            height: 100px;
        }

        .form-container button {
            background: #007bff; /* Pastel blue background */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background: #0056b3; /* Darker blue on hover */
        }

        .form-container form input[type="hidden"] {
            display: none; /* Hide hidden inputs */
        }
        /* Complaints List Styles */
        .complaints-list {
            overflow-x: auto;
        }
        
        .table-container {
    overflow-x: auto; /* Enable horizontal scrolling */
    -webkit-overflow-scrolling: touch; /* For smooth scrolling on iOS */
}

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 0.75rem;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333;
        }
        
        /* General Styles for buttons */
button {
    background-color: #dc3545; /* Red background */
    color: #fff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    margin: 0 0.5rem; /* Add margin between buttons */
    font-size: 0.875rem; /* Adjust font size for better alignment */
}

button:hover {
    background-color: #c82333; /* Darker red on hover */
}

/* Specific styles for table buttons */
.complaints-list form {
    display: inline; /* Ensure forms are inline for correct button placement */
}

.complaints-list form button {
    margin: 0; /* Remove any default margin from buttons */
}

.complaints-list form select {
    margin-right: 0.5rem; /* Add margin between select and button */
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .complaints-list form {
        display: block; /* Stack form elements vertically */
        margin-bottom: 1rem; /* Add margin below forms for spacing */
    }

    .complaints-list form button {
        margin: 0.5rem 0; /* Add vertical margin for better spacing */
        width: 100%; /* Make buttons full-width on small screens */
    }

    .complaints-list form select {
        margin-bottom: 0.5rem; /* Add margin below select for spacing */
        width: 100%; /* Make select full-width on small screens */
    }
}


    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Manage Contractors</h1>
                <button id="menu-toggle" class="menu-toggle">☰</button>
                <nav id="nav-menu">
                    <?php
                    // Check the username and conditionally display menu items
                    if ($_SESSION['admin'] == 'admin_sean') {
                        echo '<a href="admin_dashboard.php">Home</a>';
                        echo '<a href="manage_users.php">Manage Users</a>';
                        echo '<a href="manage_contractors.php">Manage Contractors</a>';
                        echo '<a href="manage_partners.php">Manage Businesses</a>';
                        echo '<a href="manage_payments.php">Manage Payments</a>';
                        echo '<a href="logout.php">Logout</a>';
                    } elseif ($_SESSION['admin'] == 'admin_julio') {
                        echo '<a href="admin_dashboard.php">Home</a>';
                        echo '<a href="manage_complaints.php">Manage Complaints</a>';
                        echo '<a href="manage_users.php">Manage Users</a>';
                        echo '<a href="manage_payments.php">Manage Payments</a>';
                        echo '<a href="logout.php">Logout</a>';
                    } elseif ($_SESSION['admin'] == 'admin_casey') {
                        echo '<a href="admin_dashboard.php">Home</a>';
                        echo '<a href="manage_bookings.php">Manage Bookings</a>';
                        echo '<a href="manage_users.php">Manage Users</a>';
                        echo '<a href="manage_payments.php">Manage Payments</a>';
                        echo '<a href="logout.php">Logout</a>';
                    }
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="content">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?= $_SESSION['message_type'] ?>">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="form-container">
                <!-- Form for Adding Contractor -->
                <form action="" method="post">
                    <h2>Add Contractor</h2>
                    <label for="contractor_name">Contractor Name:</label>
                    <input type="text" name="contractor_name" id="contractor_name" required><br><br>

                    <label for="contractor_email">Contractor Email:</label>
                    <input type="email" name="contractor_email" id="contractor_email" required><br><br>

                    <label for="contractor_phone">Contractor Phone:</label>
                    <input type="text" name="contractor_phone" id="contractor_phone" required><br><br>

                    <label for="contractor_password">Contractor Password:</label>
                    <input type="password" name="contractor_password" id="contractor_password" required><br><br>

                    <label for="contractor_address">Contractor Address:</label>
                    <input type="text" name="contractor_address" id="contractor_address" required><br><br>

                    <label for="payment_channel">Payment Channel:</label>
                    <select name="payment_channel" id="payment_channel" required>
                        <option value="bank">Bank</option>
                        <option value="gcash">GCash</option>
                        <option value="maya">Maya</option>
                        <option value="other">Other</option>
                    </select>
                    <br><br>
                    <label for="account_number">Account Number:</label>
                    <input type="text" name="account_number" id="account_number" required><br><br>

                    <input type="submit" name="add_contractor" value="Add Contractor">
                </form>
            </div>

            <div class="complaints-list">
                <h2>Contractors List</h2>
                <div class="table-container">
                    <table id="userTable" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contractor's Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Password</th>
                                <th>Address</th>
                                <th>Payment Channel</th>
                                <th>Account Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($contractors)): ?>
    <?php foreach ($contractors as $contractor): ?>
        <tr>
            <td><?php echo htmlspecialchars($contractor['id']); ?></td>
            <td><?php echo htmlspecialchars($contractor['contractor_name']); ?></td>
            <td><?php echo htmlspecialchars($contractor['contractor_email']); ?></td>
            <td><?php echo htmlspecialchars($contractor['contractor_phone']); ?></td>
            <td><?php echo htmlspecialchars($contractor['contractor_password']); ?></td>
            <td><?php echo htmlspecialchars($contractor['contractor_address']); ?></td>
            <td><?php echo htmlspecialchars($contractor['payment_channel']); ?></td>
            <td><?php echo htmlspecialchars($contractor['account_number']); ?></td>
            <td>
                <!-- Form for updating contractor information -->
               <form action="" method="post" style="display:inline;" onsubmit="return confirmDelete();">
    <input type="hidden" name="id" value="<?= htmlspecialchars($contractor['id']) ?>">
    <button type="submit" name="action" value="delete">Delete</button>
</form>
<!--<form action="" method="post" style="display:inline;">-->
<!--    <input type="hidden" name="id" value="<?= htmlspecialchars($contractor['id']) ?>">-->
<!--    <button type="submit" name="action" value="update">Update</button>-->
<!--</form>-->
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8">No contractors found.</td>
    </tr>
<?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.getElementById('nav-menu').classList.toggle('show');
        });
    </script>
    
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this contractor?');
}
</script>
 <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</body>

</html>
