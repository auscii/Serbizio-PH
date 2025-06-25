<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Include the database connection
require 'db_connection.php';

// Handle adding a new payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_payment'])) {
    $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : '';
    $payer_name = isset($_POST['payer_name']) ? $_POST['payer_name'] : '';
    $reference_id = isset($_POST['reference_id']) ? $_POST['reference_id'] : '';
    $payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : '';

    // Check if required fields are not empty
    if (!empty($payment_amount) && !empty($payer_name) && !empty($reference_id) && !empty($payment_date)) {
        // Insert the new payment into the database
        $stmt = $mysqli->prepare("INSERT INTO payments (payment_amount, payer_name, reference_id, payment_date, status) VALUES (?, ?, ?, ?, 'pending')");
        if ($stmt) {
            $stmt->bind_param('dsss', $payment_amount, $payer_name, $reference_id, $payment_date);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Payment added successfully.";
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
    } else {
        $_SESSION['message'] = "Please fill in all required fields.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage_payments.php');
    exit();
}

// Handle updating payment status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $payment_id = $_POST['payment_id'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate inputs
    if (!empty($payment_id) && !empty($status)) {
        // Prepare the SQL statement to update payment status
        $stmt = $mysqli->prepare("UPDATE payments SET status = ? WHERE reference_id = ?");
        if ($stmt) {
            $stmt->bind_param('ss', $status, $payment_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Payment status updated successfully.";
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
    } else {
        $_SESSION['message'] = "Please select a status.";
        $_SESSION['message_type'] = "error";
    }

    header('Location: manage_payments.php'); // Redirect back to the payments management page
    exit();
}
// Handle deleting a payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_payment'])) {
    $payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';

    if (!empty($payment_id)) {
        // Delete the payment from the database
        $stmt = $mysqli->prepare("DELETE FROM payments WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $payment_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Payment deleted successfully.";
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
    } else {
        $_SESSION['message'] = "Payment ID is required.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage_payments.php');
    exit();
}

// Query to get payments
$result = $mysqli->query("SELECT id, payer_name, reference_id, payment_amount, payment_date, status FROM payments ORDER BY id DESC");
$payments = [];
while ($row = $result->fetch_assoc()) {
    $row['income'] = $row['payment_amount'] * 0.20; // Calculate income as 20% of payment_amount
    $payments[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio Instant Services | Manage Receivables</title>
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

.print-button {
    margin-bottom: 10px; /* Space below the button */
    padding: 10px 20px; /* Padding for the button */
    background-color: #007bff; /* Button color */
    color: white; /* Text color */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor */
}

.print-button:hover {
    background-color: #0056b3; /* Darken button on hover */
}
@media print {
    .action-forms {
        display: none; /* Hide action forms during printing */
    }
    
    table th:last-child,
    table td:last-child {
        display: none; /* Hide the last column (Action) */
    }
}

    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Manage Receivables</h1>
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
            <div class="form-container">
                
                <!-- Display success or error message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="<?php echo $_SESSION['message_type'] == 'success' ? 'success-message' : 'error-message'; ?>">
                        <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <h2>Add Receivables</h2>
                    <label for="payment_amount">Receivable Amount:</label>
                    <input type="number" name="payment_amount" id="payment_amount" step="0.01" required><br><br>
                    <label for="payer_name">Payer Name:</label>
                    <input type="text" name="payer_name" id="payer_name" required><br><br>
                    <label for="reference_id">Reference ID:</label>
                    <input type="text" name="reference_id" id="reference_id" required><br><br>
                    <label for="payment_date">Payment Date:</label>
                    <input type="date" name="payment_date" id="payment_date" required><br><br>
                    <button type="submit" name="add_payment">Add Receivable</button>
                </form>
            </div>
            <!--<div class="form-container">-->
            <!--    <h2>Update Payment</h2>-->
                <!-- Display success or error message -->
            <!--    <?php if (isset($_SESSION['message'])): ?>-->
            <!--        <div class="<?php echo $_SESSION['message_type'] == 'success' ? 'success-message' : 'error-message'; ?>">-->
            <!--            <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>-->
            <!--        </div>-->
            <!--    <?php endif; ?>-->
            <!--    <form method="POST" action="">-->
            <!--        <label for="payment_id">Payment ID:</label>-->
            <!--        <input type="number" name="payment_id" id="payment_id" required><br><br>-->
            <!--        <label for="payment_amount">Payment Amount:</label>-->
            <!--        <input type="number" name="payment_amount" id="payment_amount" step="0.01" required><br><br>-->
            <!--        <label for="payment_date">Payment Date:</label>-->
            <!--        <input type="date" name="payment_date" id="payment_date" required><br><br>-->
            <!--        <label for="status">Status:</label>-->
            <!--        <select name="status" id="status" required>-->
            <!--            <option value="pending">Pending</option>-->
            <!--            <option value="completed">Completed</option>-->
            <!--            <option value="failed">Failed</option>-->
            <!--        </select><br><br>-->
            <!--        <button type="submit" name="update_payment">Update Payment</button>-->
            <!--    </form>-->
            <!--</div>-->
            <!--<div class="form-container">-->
            <!--    <h2>Delete Payment</h2>-->
                <!-- Display success or error message -->
            <!--    <?php if (isset($_SESSION['message'])): ?>-->
            <!--        <div class="<?php echo $_SESSION['message_type'] == 'success' ? 'success-message' : 'error-message'; ?>">-->
            <!--            <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>-->
            <!--        </div>-->
            <!--    <?php endif; ?>-->
            <!--    <form method="POST" action="">-->
            <!--        <label for="payment_id">Payment ID:</label>-->
            <!--        <input type="number" name="payment_id" id="payment_id" required><br><br>-->
            <!--        <button type="submit" name="delete_payment">Delete Payment</button>-->
            <!--    </form>-->
            <!--</div>-->
             <div class="complaints-list">
           <h2>Receivables</h2>
<div class="date-filter">
    <form method="POST" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
        
        <label for="status_filter">Status:</label>
        <select id="status_filter" name="status_filter">
            <option value="">All</option>
            <option value="paid" <?php echo (isset($_POST['status_filter']) && $_POST['status_filter'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
            <option value="pending" <?php echo (isset($_POST['status_filter']) && $_POST['status_filter'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="refunded" <?php echo (isset($_POST['status_filter']) && $_POST['status_filter'] === 'refunded') ? 'selected' : ''; ?>>Refunded</option>
        </select>

        <button type="submit" name="filter">Filter</button>
        <button type="submit" name="reset">Reset</button> <!-- Reset button -->
        <button onclick="printTable()" class="print-button">Print</button>
    </form>
</div>

<div class="table-container">
<?php
// Assuming $payments contains the list of all payments
$filtered_payments = [];
$total_income = 0;

// Check if the filter form is submitted
if (isset($_POST['filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status_filter = $_POST['status_filter'];

    // Filter payments based on date range and status
    foreach ($payments as $payment) {
        $dateCondition = true;
        $statusCondition = true;

        if (!empty($start_date) && !empty($end_date)) {
            $dateCondition = ($payment['payment_date'] >= $start_date && $payment['payment_date'] <= $end_date);
        }

        if (!empty($status_filter)) {
            $statusCondition = ($payment['status'] === $status_filter);
        }

        if ($dateCondition && $statusCondition) {
            $filtered_payments[] = $payment;
        }
    }
} else {
    // If no filter is applied, display all payments
    $filtered_payments = $payments;
}

// Calculate total income for filtered payments
foreach ($filtered_payments as $payment) {
    $total_income += $payment['payment_amount'] * 0.10;
}
?>

<!-- Display the total income above the table -->
<h3>Total Income (10%): PHP <?php echo number_format($total_income, 2); ?></h3>

<table id="userTable" class="display">
    <thead>
        <tr>
            <th>No.</th>
            <th>Payer Name</th>
            <th>Reference ID</th>
            <th>Payment Amount</th>
            <th>Payment Date</th>
            <th>Status</th>
            <th>Income (10%)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1; // Initialize serial number counter
        foreach ($filtered_payments as $payment): ?>
            <tr>
                <td><?php echo $sno++; ?></td> <!-- Display the serial number and increment -->
                <td><?php echo htmlspecialchars($payment['payer_name']); ?></td>
                <td><?php echo htmlspecialchars($payment['reference_id']); ?></td>
                <td><?php echo htmlspecialchars(number_format($payment['payment_amount'], 2)); ?></td>
                <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                <td><?php echo htmlspecialchars($payment['status']); ?></td>
                <td><?php echo htmlspecialchars(number_format($payment['payment_amount'] * 0.10, 2)); ?></td>
                <td>
                    <!-- Form for updating the payment status -->
                    <form method="POST" action="" class="action-form">
                        <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['reference_id']); ?>">
                        <select name="status" class="status-dropdown" required>
                            <option value="">Select Status</option>
                            <option value="paid" <?php echo ($payment['status'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
                            <option value="pending" <?php echo ($payment['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="refunded" <?php echo ($payment['status'] === 'refunded') ? 'selected' : ''; ?>>Refunded</option>
                        </select>
                        <button type="submit" name="update_status" class="action-button">Update Status</button>
                    </form>

                    <!-- Form for deleting the payment -->
                    <form method="POST" action="" class="action-form">
                        <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['id']); ?>">
                        <button type="submit" name="delete_payment" class="action-button delete" onclick="return confirm('Are you sure you want to delete this payment?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

        </div>
    </div>
    </div>
    <script>
        // JavaScript to toggle the menu on small screens
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.getElementById('nav-menu').classList.toggle('show');
        });
    </script>
    <script>
function filterByDate() {
    const startDate = document.getElementById('start_date').value; // format: yyyy-mm-dd
    const endDate = document.getElementById('end_date').value;     // format: yyyy-mm-dd

    // Convert input dates to the format yy-dd-mm for comparison
    const startFormatted = startDate ? startDate.slice(2, 10).split('-').reverse().join('-') : '';
    const endFormatted = endDate ? endDate.slice(2, 10).split('-').reverse().join('-') : '';

    const rows = document.querySelectorAll('.table-container tbody tr');

    rows.forEach(row => {
        const paymentDate = row.cells[4].textContent; // Assuming payment date is in the 5th cell (index 4)

        // Log to check the values
        console.log(`Payment Date: ${paymentDate}, Start Date: ${startFormatted}, End Date: ${endFormatted}`);

        // Check if the payment date is within the selected range
        if (
            (!startFormatted || paymentDate >= startFormatted) && 
            (!endFormatted || paymentDate <= endFormatted)
        ) {
            row.style.display = ''; // Show the row
        } else {
            row.style.display = 'none'; // Hide the row
        }
    });
}

function resetFilters() {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    const rows = document.querySelectorAll('.table-container tbody tr');
    rows.forEach(row => row.style.display = ''); // Show all rows
}

function printTable() {
    const actionForms = document.querySelectorAll('.action-forms'); // Select all action forms
    actionForms.forEach(form => form.style.display = 'none'); // Hide action forms

    const printContents = document.querySelector('.table-container').innerHTML; // Get table contents
    const originalContents = document.body.innerHTML; // Store original body contents

    document.body.innerHTML = printContents; // Replace body with table contents
    window.print(); // Trigger print dialog
    document.body.innerHTML = originalContents; // Restore original body contents

    actionForms.forEach(form => form.style.display = 'block'); // Show action forms again
}
</script>
 <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</body>
</html>
