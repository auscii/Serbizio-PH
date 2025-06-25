<?php
session_start();



// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}



// Include the database connection
require 'db_connection.php'; 

// Query to get counts
$queries = [
    'individuals' => "SELECT COUNT(*) AS count FROM individuals",
    'contractors' => "SELECT COUNT(*) AS count FROM individuals where status='deployed'",
    'companies' => "SELECT COUNT(*) AS count FROM companies",
    'complaints' => "SELECT COUNT(*) AS count FROM complaints",
    'company_requests' => "SELECT COUNT(*) AS count FROM company_requests"
];

$counts = [];
foreach ($queries as $key => $query) {
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $counts[$key] = $row['count'];
}

// Query to get data for charts (e.g., user registration over time)
$user_registrations_query = "SELECT DATE(created_at) AS reg_date, COUNT(*) AS reg_count FROM individuals GROUP BY reg_date ORDER BY reg_date DESC LIMIT 7";
$user_registrations = $mysqli->query($user_registrations_query);
$reg_dates = [];
$reg_counts = [];

while ($row = $user_registrations->fetch_assoc()) {
    $reg_dates[] = $row['reg_date'];
    $reg_counts[] = $row['reg_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio Instant Services | Admin Dashboard</title>
    <link rel="icon" href="../assets/serbizio1.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file if needed -->
    <style>
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

/* Add your custom styles */
        .chart-container {
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        /* Specific card color classes */
.card-individuals {
    background: #4CAF50; /* Green */
    color: #f1f1f1;
}

.card-contractors {
    background: #2196F3; /* Blue */
     color: #f1f1f1;
}

.card-companies {
    background: #FF9800; /* Orange */
     color: #f1f1f1;
}

.card-complaints {
    background: #F44336; /* Red */
     color: #f1f1f1;
}

.card-requests {
    background: #9C27B0; /* Purple */
     color: #f1f1f1;
}
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Admin Dashboard</h1>
                <button class="menu-toggle" id="menu-toggle">☰</button>
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
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</h2>
            <p>You are now logged in to the admin dashboard.</p>
            <p>Use the navigation menu to access different sections of the admin panel.</p>
        </div>
        <div class="cards-container">
    <div class="card card-individuals">
        <h3>Total Service Providers</h3>
        <p><?php echo htmlspecialchars($counts['individuals']); ?></p>
    </div>
    <div class="card card-contractors">
        <h3>Total Deployed</h3>
        <p><?php echo htmlspecialchars($counts['contractors']); ?></p>
    </div>
    <div class="card card-companies">
        <h3>Total Companies</h3>
        <p><?php echo htmlspecialchars($counts['companies']); ?></p>
    </div>
    <div class="card card-complaints">
        <h3>Total Complaints</h3>
        <p><?php echo htmlspecialchars($counts['complaints']); ?></p>
    </div>
    <div class="card card-requests">
        <h3>Total Pooling Request</h3>
        <p><?php echo htmlspecialchars($counts['company_requests']); ?></p>
    </div>
</div>

        <!-- Chart.js Graph Section -->
        <div class="chart-container">
            <h3>Service Providers (Last 7 Days)</h3>
            <canvas id="userRegistrationsChart"></canvas>
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
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data for User Registrations Chart
        const regDates = <?php echo json_encode($reg_dates); ?>;
        const regCounts = <?php echo json_encode($reg_counts); ?>;

        const ctx = document.getElementById('userRegistrationsChart').getContext('2d');
        const userRegistrationsChart = new Chart(ctx, {
            type: 'bar', // You can change to 'line', 'pie', etc.
            data: {
                labels: regDates,
                datasets: [{
                    label: 'User Registrations',
                    data: regCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Toggle Menu Script
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
