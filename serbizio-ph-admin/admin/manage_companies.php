<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

// Include the database connection
require 'db_connection.php';

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle Partner Actions (Delete Only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_company'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['message'] = 'CSRF token validation failed';
        $_SESSION['message_type'] = 'error';
        header('Location: manage_partners.php');
        exit();
    }

    $partner_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($partner_id > 0) {
        // Prepare and execute the delete query
        $sql = "DELETE FROM companies WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $partner_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Company deleted successfully!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to delete company: ' . $stmt->error;
                $_SESSION['message_type'] = 'error';
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = 'Error preparing statement: ' . $mysqli->error;
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Invalid company ID.';
        $_SESSION['message_type'] = 'error';
    }

    header('Location: manage_companies.php');
    exit();
}

$query = "SELECT * FROM companies";
$result = $mysqli->query($query);

if ($result) {
    $partners = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $partners = [];
    $_SESSION['message'] = "Error retrieving companies: " . $mysqli->error;
    $_SESSION['message_type'] = 'error';
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio Instant Services | Manage Companies</title>
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
                <h1>Manage Companies</h1>
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
        <div class="content">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?= $_SESSION['message_type'] ?>">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            
            <div class="complaints-list">
                <h2>Registered Companies</h2>
                <div class="table-container">
                    <table id="userTable" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile Photo</th>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Mobile Number</th>
                                <th>Contact Person</th>
                                <th>Position</th>
                                <th>Industry</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($partners)): ?>
    <?php foreach ($partners as $partner): ?>
        <tr>
            <td><?php echo htmlspecialchars($partner['id']); ?></td>
            <td>
                <?php if (!empty($partner['profile_image'])): ?>
                    <img src="../<?php echo htmlspecialchars($partner['profile_image']); ?>" alt="Profile Photo" style="width: 50px; height: 50px;">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($partner['company_name']); ?></td>
            <td><?php echo htmlspecialchars($partner['email']); ?></td>
            <td><?php echo htmlspecialchars($partner['mobile_num']); ?></td>
           <td><?php echo htmlspecialchars($partner['first_name']) . ' ' . htmlspecialchars($partner['last_name']); ?></td>
           <td><?php echo htmlspecialchars($partner['position']); ?></td>
           <td><?php echo htmlspecialchars($partner['industry']); ?></td>
            <td><?php echo htmlspecialchars($partner['city']); ?></td>
            <td>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($partner['id']); ?>">
                        <button type="submit" name="delete_company" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                    </form>
                </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="9">No business found.</td>
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
