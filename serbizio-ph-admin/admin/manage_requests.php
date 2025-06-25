<?php
session_start();



// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

// Fetch the data from the database
$query = "SELECT * FROM company_requests"; // Your actual SQL query
$result = $mysqli->query($query);

// Check if the query ran successfully
if ($result === false) {
    die("Error: " . $mysqli->error); // Print error if query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Company Requests</title>
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
        .form-container button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #0056b3;
        }
        label {
    display: block; /* Ensures the label occupies a whole line */
    margin-bottom: 5px; /* Space between label and input/textarea */
}

textarea {
    width: 100%; /* Ensures the textarea takes full width */
    padding: 8px; /* Adds some padding for comfort */
    border: 1px solid #ccc; /* Light border for better visibility */
    border-radius: 4px; /* Rounded corners */
}

    </style>
</head>
<body>


    <header>
        <div class="container">
            <div class="header-content">
                <h1>Manage Requests</h1>
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

            <form method="POST" action="process_add_request.php">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="request_date">Date:</label>
                    <input type="date" id="request_date" name="request_date" required>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="company_name">Company Name:</label>
                    <input type="text" id="company_name" name="company_name" required>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="requested_by">Requested By:</label>
                    <input type="text" id="requested_by" name="requested_by" required>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="2" required></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="budget_allocation">Budget Allocation:</label>
                    <input type="number" id="budget_allocation" name="budget_allocation" step="0.01" required>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="comments">Comments:</label>
                    <textarea id="comments" name="comments" rows="2"></textarea>
                </div>

                <button type="submit" name="add_request" class="button">Submit Request</button>
            </form>
       
            
            <div class="complaints-list">
                <h2>Company Pool Request</h2>
                <div class="table-container">
                    <table id="userTable" class="display">
                         <thead>
            <tr>
                <th>Date</th>
                <th>Company Name</th>
                <th>Requested By</th>
                <th>Description</th>
                <th>Status</th>
                <th>Budget Allocation</th>
                <th>10% Income</th>
                <th>Comments</th>
                 <th>Update</th>
                 <th>Delete</th>
              
            </tr>
        </thead>
                    <tbody>
    <?php
    // Check if there are any results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $budgetAllocation = $row['budget_allocation']; // Assuming this column exists
            $income = $budgetAllocation * 0.1; // Calculate 10% income

            echo "<tr>
                <td>{$row['request_date']}</td>
                <td>{$row['company_name']}</td>
                <td>{$row['requested_by']}</td>
                <td>{$row['description']}</td>
                <td>{$row['status']}</td>
                <td>{$budgetAllocation}</td>
                <td>{$income}</td>
                <td>{$row['comments']}</td>
                <td>
                    <form action='update_status.php' method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <select name='status'>
                            <option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                            <option value='in progress' " . ($row['status'] == 'in progress' ? 'selected' : '') . ">In Progress</option>
                            <option value='completed' " . ($row['status'] == 'completed' ? 'selected' : '') . ">Completed</option>
                        </select>
                        <button type='submit' class='button'>Update Status</button>
                    </form>
                </td>
                <td>
                    <a class='button' href='delete_request.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this request?\");'>Delete</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No requests found.</td></tr>";
    }
    ?>
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
