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

// Display messages
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

// Handle deleting a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($user_id > 0) {
        $stmt = $mysqli->prepare("DELETE FROM individuals WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "User deleted successfully.";
            } else {
                $_SESSION['error'] = "Error deleting user: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error preparing statement: " . $mysqli->error;
        }
        
        // Redirect to avoid form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['error'] = "Invalid user ID.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}

// Handle updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $new_username = isset($_POST['username']) ? $_POST['username'] : '';
    $new_email = isset($_POST['email']) ? $_POST['email'] : '';

    if (!empty($user_id) && !empty($new_username) && !empty($new_email)) {
        $stmt = $mysqli->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('ssi', $new_username, $new_email, $user_id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "User ID, username or email is missing.";
    }
}

// Check if the form has been submitted and update_status button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    // Sanitize and retrieve input values
    $user_id = htmlspecialchars($_POST['user_id']);
    $status = htmlspecialchars($_POST['status']);

    // Prepare the SQL update statement
    $sql = "UPDATE individuals SET status = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    // Bind the parameters and execute the query
    if ($stmt) {
        $stmt->bind_param('si', $status, $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Provider status updated successfully.";
        } else {
            $_SESSION['error'] = "Error updating status: " . $mysqli->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare statement: " . $mysqli->error;
    }

    // Redirect to avoid form re-submission on page reload
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Query to get users
$result = $mysqli->query("SELECT * FROM individuals ORDER BY id desc");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio Instant Services | Manage Poolings</title>
    <link rel="icon" href="../assets/serbizio1.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
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
            width: 100%;
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
        
        /* General styles for forms */
        .form-container input[type="text"], 
        .form-container input[type="email"], 
        .form-container input[type="password"],
        .form-container select {
            width: calc(100% - 22px); /* Adjusted for padding */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box; /* Ensures padding is included in width */
        }
        
        .form-container input[type="submit"] {
            background-color: #007bff; /* Pastel blue */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .form-container input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
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

/* Alert styles */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
        
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Manage Poolings</h1>
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
    
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
    <div class="complaints-list">
        <h2>Pooling List</h2>
        <button onclick="printTable()">Print Filtered List</button>
        <button id="resetFilters" onclick="resetFilters()">Reset Filters</button>

        <!-- Status Filter Dropdown -->
        <label for="statusFilter">Filter by Status:</label>
        <select id="statusFilter" onchange="filterByStatus()">
            <option value="">All</option>
            <option value="deployed">Deployed</option>
            <option value="hired">Hired</option>
            <option value="pending">Pending</option>
        </select>

        <br><br>
        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile Photo</th>
                    <th>ID Photo</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Location</th>
                    <th>Industry</th>
                    <th>Position</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td>
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="../<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Photo" style="width: 50px; height: 50px;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($user['id_photo'])): ?>
                                <a href="../<?php echo htmlspecialchars($user['id_photo']); ?>" target="_blank">
                                    <img src="../<?php echo htmlspecialchars($user['id_photo']); ?>" alt="ID Photo" style="width: 50px; height: 50px;">
                                </a>
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['middle_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['mobile_num']); ?></td>
                        <td><?php echo htmlspecialchars($user['city']); ?></td>
                        <td><?php echo htmlspecialchars($user['industry']); ?></td>
                        <td><?php echo htmlspecialchars($user['position']); ?></td>
                        <td>
                            <?php if (!empty($user['resume'])): ?>
                                <a href="../<?php echo htmlspecialchars($user['resume']); ?>" download>Download Resume</a>
                            <?php else: ?>
                                No Resume
                            <?php endif; ?>
                        </td>
                        <td class="status-cell"><?php echo htmlspecialchars($user['status']); ?></td>
                        <td>
                            <!-- Form for updating user status -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                <select name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="deployed" <?php echo ($user['status'] === 'deployed') ? 'selected' : ''; ?>>Deployed</option>
                                    <option value="hired" <?php echo ($user['status'] === 'hired') ? 'selected' : ''; ?>>Hired</option>
                                    <option value="pending" <?php echo ($user['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                </select>
                                <button type="submit" style="background-color: #007bff;" name="update_status">Update Status</button>
                            </form>
                            
                            <!-- Form for deleting the user -->
                            <form method="POST" action="" style="display:inline;" onsubmit="return confirmDelete()">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                <button type="submit" name="delete_user">Delete</button>
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
    <script>
        function filterByStatus() {
    var filterValue = document.getElementById("statusFilter").value.toLowerCase();
    var rows = document.querySelectorAll("#userTable tbody tr");
    
    rows.forEach(row => {
        var status = row.querySelector(".status-cell").textContent.toLowerCase();
        if (filterValue === "" || status === filterValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
    </script>
    <script>
    $(document).ready(function () {
        var table = $('#userTable').DataTable();

        // Handle reset button click
        $('#resetFilters').click(function () {
            // Refresh the window to reset filters and reload the page
            location.reload();
        });
    });
    
      function confirmDelete() {
        return confirm("Are you sure you want to delete this user? This action cannot be undone.");
    }

  function printTable() {
    // Create title and prepared by content
    var title = "<h2>Serbizio Instant Services Pool List</h2>";
    var preparedBy = "<p><strong>Prepared by:</strong> ________________________</p><p><strong>Date:</strong> " + new Date().toLocaleDateString() + "</p>";

    // Clone the table to modify it for printing
    var originalTable = document.getElementById('userTable').outerHTML;
    var printContent = title + preparedBy + originalTable;

    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print</title>');

    // CSS for hiding Status, Actions, and the 14th column in print view
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('h2, p { text-align: center; }');
    // Hide columns 12 (Status), 13 (Actions), and 14 in print view
    printWindow.document.write('@media print { th:nth-child(12), td:nth-child(12), th:nth-child(13), td:nth-child(13), th:nth-child(14), td:nth-child(14) { display: none; } }');
    printWindow.document.write('</style>');

    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close(); // Close the document to apply styles

    printWindow.onload = function () {
        printWindow.print(); // Print when the window loads
        printWindow.onafterprint = function () {
            printWindow.close(); // Close the print window after printing
        };
    };
}



</script>


</body>
</html>
