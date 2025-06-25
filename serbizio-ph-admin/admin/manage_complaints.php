<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'] ?? '';
// Include the database connection
require 'db_connection.php'; 

// Handle adding a new complaint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_complaint'])) {
    $complaint_text = isset($_POST['complaint_text']) ? $_POST['complaint_text'] : '';
    $complainant_name = isset($_POST['complainant_name']) ? $_POST['complainant_name'] : '';
    $reference_id = isset($_POST['reference_id']) ? $_POST['reference_id'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Check if required fields are not empty
    if (!empty($complaint_text) && !empty($complainant_name) && !empty($reference_id) && !empty($status)) {
        // Insert the new complaint into the database
        $stmt = $mysqli->prepare("INSERT INTO complaints (complaint_text, complainant_name, reference_id, status) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssss', $complaint_text, $complainant_name, $reference_id, $status);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Please fill in all required fields.";
    }
}

// Handle deleting a complaint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_complaint'])) {
    $complaint_id = isset($_POST['complaint_id']) ? $_POST['complaint_id'] : '';

    if (!empty($complaint_id)) {
        $stmt = $mysqli->prepare("DELETE FROM complaints WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $complaint_id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Complaint ID is missing.";
    }
}

// Handle updating complaint status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $complaint_id = isset($_POST['complaint_id']) ? $_POST['complaint_id'] : '';
    $new_status = isset($_POST['status']) ? $_POST['status'] : '';

    if (!empty($complaint_id) && !empty($new_status)) {
        $stmt = $mysqli->prepare("UPDATE complaints SET status = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('si', $new_status, $complaint_id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Complaint ID or status is missing.";
    }
}

// Query to get complaints
$result = $mysqli->query("SELECT id, complainant_name, reference_id, complaint_text, status, created_at FROM complaints ORDER BY created_at DESC");
$complaints = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio | Manage Complaints</title>
    <link rel="icon" href="../assets/serbizio1.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
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
                <h1>Manage Complaints</h1>
                <button id="menu-toggle" class="menu-toggle">☰</button>
                <nav id="nav-menu">
                     <?php
    
   // Check the username and conditionally display menu items
    if ($_SESSION['admin'] == 'admin_sean') {
        echo '<a href="admin_dashboard.php">Home</a>';
        echo '<a href="manage_providers.php">Manage Service Providers</a>';
        // echo '<a href="manage_contractors.php">Manage Contractors</a>';
        echo '<a href="manage_companies.php">Manage Companies</a>';
        echo '<a href="manage_requests.php">Manage Requests</a>';
        echo '<a href="manage_posts.php">Manage Posts</a>';
        echo '<a href="manage_payments.php">Manage Receivables</a>';
        echo '<a href="logout.php">Logout</a>';
        
    }
    ?>

    <?php
    // Check the username and conditionally display menu items
    if ($_SESSION['admin'] == 'admin_julio') {
        echo '<a href="admin_dashboard.php">Home</a>';
        echo '<a href="manage_complaints.php">Manage Complaints</a>';
        echo '<a href="manage_providers.php">Manage Service Providers</a>';
        echo '<a href="manage_payments.php">View Receivables</a>';
        echo '<a href="logout.php">Logout</a>';
        
    }
    ?>
    
     <?php
    // Check the username and conditionally display menu items
    if ($_SESSION['admin'] == 'admin_casey') {
        echo '<a href="admin_dashboard.php">Home</a>';
        echo '<a href="manage_providers.php">Manage Service Providers</a>';
        echo '<a href="manage_pooling.php">Manage Pooling</a>';
        // echo '<a href="manage_users.php">Manage Users</a>';
        echo '<a href="manage_payments.php">View Receivables</a>';
        echo '<a href="logout.php">Logout</a>';
        
    }
    ?>
    
            </div>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Add New Complaint</h2>
            <form method="POST" action="">
    <label for="complainant_name">Complainant's Name:</label>
    <input type="text" id="complainant_name" name="complainant_name" required placeholder="Enter complainant's name...">
    <br><br>

    <label for="reference_id">Reference ID:</label>
    <input type="text" id="reference_id" name="reference_id" required placeholder="Enter reference ID...">
    <br><br>

    <label for="complaint_text">Complaint Text:</label><br>
    <textarea id="complaint_text" name="complaint_text" required placeholder="Enter complaint text..."></textarea>
    <br><br>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="" disabled selected>Select status...</option>
        <option value="Pending">Pending</option>
        <option value="Resolved">Resolved</option>
        <option value="In Progress">In Progress</option>
    </select>
    <br><br>

    <button type="submit" name="add_complaint">Add Complaint</button>
</form>

        </div>

        <div class="complaints-list">
            <h2>Existing Complaints</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reference ID</th>
                        <th>Complainant's Name</th>
                        <th>Complaint</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($complaint['id']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['reference_id']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['complainant_name']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['complaint_text']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['created_at']); ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($complaint['id']); ?>">
                                    <select name="status" required>
                                        <option value="" disabled>Select status...</option>
                                        <option value="Pending" <?php echo $complaint['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Resolved" <?php echo $complaint['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        <option value="In Progress" <?php echo $complaint['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                    </select>
                                    <button type="submit" name="update_status">Update Status</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($complaint['id']); ?>">
                                    <button type="submit" name="delete_complaint">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        var navMenu = document.getElementById('nav-menu');
        if (navMenu.classList.contains('show')) {
            navMenu.classList.remove('show');
        } else {
            navMenu.classList.add('show');
        }
    });
    </script>
</body>
</html>
