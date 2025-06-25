<?php
session_start(); // Start the session to access messages

// Check for success or error messages and store them in variables
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear messages after displaying
unset($_SESSION['success']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Signup Form | Serbizio Instant Services</title>
    <link rel="shortcut icon" href="assets/serbizio1.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items at the top */
            height: 100vh;
            overflow: auto; /* Allow scrolling if needed */
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 40px auto; /* Increased top margin */
        }

        h1 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 28px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            color: #555;
        }

        form {
            display: flex;
            flex-direction: column;
            padding: 15px; /* Added padding to form for inner spacing */
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #007bff; /* Blue border on focus */
            outline: none; /* Remove outline */
        }

        input[type="submit"], .back-button {
            background-color: #007bff; /* Blue color */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* Maintain top margin for buttons */
            padding: 12px; /* Consistent padding for buttons */
            border-radius: 4px;
            font-size: 16px; /* Increased font size for readability */
            display: flex; /* Flexbox for icon and text alignment */
            align-items: center; /* Center items vertically */
            justify-content: center; /* Center items horizontally */
        }

        input[type="submit"]:hover, .back-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px; /* Space below error message */
        }

        /* Add some space between icon and text */
        .button-icon {
            margin-right: 8px; /* Space between icon and button text */
        }
        .password-container {
        position: relative;
        
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 15px; /* Reduced padding on medium screens */
            }

            h1 {
                font-size: 24px; /* Smaller font size for headings */
            }

            input, select {
                font-size: 14px; /* Slightly smaller input/select font size */
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px; /* Further reduce padding for very small screens */
            }

            h1 {
                font-size: 20px; /* Further reduce heading size */
            }

            input, select {
                font-size: 12px; /* Further reduce input/select font size */
            }

            input[type="submit"], .back-button {
                padding: 8px; /* Smaller button padding */
            }
        }
        /*success and error messages*/
        .success-message {
    color: green;
    font-weight: bold;
}

.error-message {
    color: red;
    font-weight: bold;
}

    </style>

</head>
<body>

<div class="container">
    <h2>Individual Sign Up</h2>
    <h1 class="form-title">Create Your Account</h1>
     <!-- Display success message -->
    <?php if ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?><br><br>

    <!-- Display error message -->
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form id="signupForm" enctype="multipart/form-data" action="individual_reg.php" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" placeholder="First Name" required>

        <label for="middle_name">Middle Name (Optional)</label>
        <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name (Optional)">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>

        <label for="email">Email (Optional)</label>
        <input type="email" name="email" id="email" placeholder="Email (Optional)">

        <label for="password">Password</label>
        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span id="togglePassword" class="toggle-password" onclick="togglePasswordVisibility()">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
        </div>

        <label for="mobile_num">Mobile Number</label>
        <input type="tel" name="mobile_num" id="mobile_num" placeholder="Mobile Number" required>

        <label for="region">Region</label>
        <select name="region" id="region" onchange="updateCities()" required>
            <option value="">Select Region</option>
            <option value="Luzon">Luzon</option>
            <option value="Visayas">Visayas</option>
            <option value="Mindanao">Mindanao</option>
        </select>

        <label for="city">City</label>
        <select name="city" id="city" required>
            <option value="">Select City</option>
            <!-- Cities will be populated based on region selection -->
        </select>

        <label for="profile_image">Upload Profile Photo (Optional)</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">

        <label for="resume">Upload Resume (Optional)</label>
        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx">

        <label for="id_photo">Upload ID Photo (Optional)</label>
        <input type="file" name="id_photo" id="id_photo" accept="image/*">

        <label for="industry">Industry</label>
        <select name="industry" id="industry" onchange="updatePositions()" required>
            <option value="">Select Industry</option>
            <option value="IT">Information Technology</option>
            <option value="Construction">Construction</option>
            <option value="Healthcare">Healthcare</option>
            <option value="Education">Education</option>
            <option value="Finance">Finance</option>
            <option value="Retail">Retail</option>
            <option value="Hospitality">Hospitality</option>
            <option value="Manufacturing">Manufacturing</option>
            <option value="Transportation">Transportation</option>
            <option value="Agriculture">Agriculture</option>
            <option value="Real Estate">Real Estate</option>
            <option value="Media">Media</option>
            <option value="Telecommunications">Telecommunications</option>
            <option value="Energy">Energy</option>
            <option value="Legal">Legal</option>
            <option value="Consulting">Consulting</option>
            <option value="Tourism">Tourism</option>
            <option value="Automotive">Automotive</option>
            <option value="Pharmaceutical">Pharmaceutical</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Fashion">Fashion</option>
            <option value="Food & Beverage">Food & Beverage</option>
            <option value="Security">Security</option>
            <option value="Logistics">Logistics</option>
            <option value="Household">Household Services</option>
            <option value="Laborers">Laborers in Factories</option>
            <option value="Domestic">Domestic Workers</option>
            <option value="BPO">Business Process Outsourcing (BPO)</option>
            <option value="Restaurants">Restaurant Services</option>
        </select>

        <label for="position">Position Applying For</label>
        <select name="position" id="position" required>
            <option value="">Select Position</option>
            <!-- Positions will be populated based on industry selection -->
        </select>

        <input type="submit" value="Sign Up">
        <div id="message" class="error-message"></div> <!-- To display error/success messages -->
    </form>
</div>


    <script>
    // Define positions based on industries
    const positionsByIndustry = {
        IT: ["Software Developer", "Network Engineer", "IT Support", "Data Analyst", "Cybersecurity Specialist"],
        Construction: ["Civil Engineer", "Site Supervisor", "Mason", "Carpenter", "Electrician"],
        Healthcare: ["Nurse", "Doctor", "Pharmacist", "Medical Technologist", "Caregiver"],
        Education: ["Teacher", "Professor", "School Administrator", "Guidance Counselor", "Tutor"],
        Finance: ["Accountant", "Financial Analyst", "Bank Teller", "Loan Officer", "Auditor"],
        Retail: ["Store Manager", "Sales Associate", "Cashier", "Inventory Manager", "Customer Service Representative"],
        Hospitality: ["Hotel Manager", "Housekeeping Staff", "Concierge", "Food and Beverage Manager", "Event Coordinator"],
        Manufacturing: ["Production Supervisor", "Quality Control Inspector", "Machine Operator", "Assembler", "Warehouse Worker"],
        Transportation: ["Logistics Coordinator", "Truck Driver", "Fleet Manager", "Warehouse Associate", "Dispatch Officer"],
        Agriculture: ["Farm Manager", "Agricultural Technician", "Livestock Handler", "Crop Consultant", "Farm Laborer"],
        RealEstate: ["Real Estate Agent", "Property Manager", "Appraiser", "Leasing Consultant", "Real Estate Analyst"],
        Media: ["Journalist", "Editor", "Graphic Designer", "Marketing Specialist", "Content Creator"],
        Telecommunications: ["Network Technician", "Sales Representative", "Customer Service Agent", "Telecom Engineer", "Field Technician"],
        Energy: ["Electrical Engineer", "Energy Consultant", "Solar Technician", "Wind Farm Operator", "Power Plant Operator"],
        Legal: ["Lawyer", "Paralegal", "Legal Assistant", "Corporate Counsel", "Litigation Support Specialist"],
        Consulting: ["Management Consultant", "Business Analyst", "Strategy Consultant", "Operations Consultant", "HR Consultant"],
        Tourism: ["Tour Guide", "Travel Agent", "Hotel Receptionist", "Event Planner", "Tour Coordinator"],
        Automotive: ["Auto Mechanic", "Sales Associate", "Service Manager", "Body Shop Technician", "Parts Specialist"],
        Pharmaceutical: ["Pharmacist", "Medical Sales Representative", "Clinical Research Associate", "Regulatory Affairs Specialist", "Quality Assurance Specialist"],
        Entertainment: ["Actor", "Director", "Producer", "Music Producer", "Sound Engineer"],
        Fashion: ["Fashion Designer", "Model", "Fashion Buyer", "Stylist", "Fashion Merchandiser"],
        FoodAndBeverage: ["Chef", "Food Server", "Bartender", "Catering Manager", "Kitchen Staff"],
        Security: ["Security Guard", "Loss Prevention Specialist", "Security Manager", "Surveillance Operator", "Personal Security"],
        Logistics: ["Supply Chain Manager", "Logistics Coordinator", "Warehouse Manager", "Transportation Manager", "Inventory Control Specialist"],
        Household: ["Maid", "Housekeeper", "Personal Assistant", "Nanny", "Cook"],
        Laborers: ["Factory Worker", "Construction Laborer", "Field Worker", "Warehouse Laborer", "Cleaner"],
        Domestic: ["Household Helper", "Caregiver", "Nanny", "Cook", "Gardener"],
        BPO: ["Customer Service Representative", "Technical Support Agent", "Sales Agent", "HR Specialist", "Quality Analyst"],
        Restaurants: ["Chef", "Server", "Host", "Barista", "Manager"]
    };

   const citiesByRegion = {
    Luzon: [
        "Manila", "Quezon City", "Cavite City", "Batangas City", "Laguna (Santa Cruz, San Pablo, etc.)",
        "Pampanga (San Fernando, Angeles, etc.)", "Bataan (Balanga, Mariveles, etc.)", "Bulacan (Malolos, San Jose del Monte, etc.)",
        "Rizal (Antipolo, Taytay, etc.)", "Baguio City", "Antipolo City", "San Pablo City", "Dasmariñas City",
        "Santa Rosa City", "San Fernando City (Pampanga)", "Malabon City", "Navotas City", "Valenzuela City",
        "Caloocan City", "Marikina City", "Muntinlupa City", "Taguig City", "Pasig City", "Pasay City", 
        "Mandaluyong City", "Makati City", "Vigan City", "San Fernando City (La Union)", "Urdaneta City", 
        "Ilagan City", "Santiago City", "Laoag City", "Lucena City", "Hagonoy", "Tarlac City", 
        "Cabanatuan City", "Calasiao", "San Carlos City (Pangasinan)", "Naga City", "Legazpi City", 
        "Iba", "Lingayen", "San Mateo", "Cainta", "Malolos City", "Paniqui", "Sorsogon City", 
        "Tanauan City", "Angeles City", "San Jose (Occidental Mindoro)", "Bayambang", "San Jose del Monte",
        "Manaoag", "Magsaysay (Rizal)", "Lipa City", "Balanga City", "San Carlos City (Pangasinan)", 
        "Laoag City", "San Pablo City", "San Antonio", "San Felipe", "Santa Maria", "Bacoor City", 
        "Las Piñas City", "Bataan (Dinalupihan, Mariveles, etc.)", "Talisay (Batangas)", "Makati", 
        "Calauan", "Binan"
    ],
    Visayas: [
        "Cebu City", "Iloilo City", "Bacolod City", "Tacloban City", "Ormoc City", "Dumaguete City",
        "Tagbilaran City", "San Carlos City (Negros Occidental)", "Silay City", "Talisay City (Negros Occidental)",
        "Kalibo", "Roxas City", "Borongan City", "Bayawan City", "Carcar City", "Mandaue City",
        "Lapu-Lapu City", "Bogo City", "Cebu City (Toledo, Daanbantayan, etc.)", "Escalante City", "Toledo City",
        "Samar (Catbalogan)", "Guihulngan City", "San Jose (Antique)", "Moalboal", "Pavia", "Siquijor (Larena)",
        "Siquijor (Siquijor)", "Biliran (Naval)", "Concepcion (Iloilo)", "San Enrique", "Ajuy", "Daanbantayan",
        "Oton", "Binalbagan", "Hinigaran", "La Carlota City", "Victorias City", "Hinigaran", "Talisay City (Cebu)",
        "Bantayan", "Malabuyoc", "Alcoy", "San Fernando (Cebu)", "Dumangas", "Danao City", "Sibonga", 
        "Oslob", "Mactan", "Bantayan Island", "San Jose (Antique)", "Sumilon Island"
    ],
    Mindanao: [
        "Davao City", "Cagayan de Oro City", "Zamboanga City", "General Santos City", "Iligan City",
        "Butuan City", "Koronadal City", "Surigao City", "Cotabato City", "Digos City", "Tagum City",
        "Malaybalay City", "Valencia City", "Tacurong City", "Kidapawan City", "Gingoog City", "Ozamiz City",
        "Puerto Princesa City", "Lamitan City", "Basilan (Isabela City)", "Sultan Kudarat (Koronadal City)",
        "Marawi City", "Balingasag", "Bongao", "Dapitan City", "Bislig City", "Tandag City", "Mati City",
        "Polomolok", "San Francisco (Agusan del Sur)", "Carmen (North Cotabato)", "San Miguel (Surigao del Sur)",
        "Maguindanao (Shariff Aguak)", "Tawi-Tawi (Bongao)", "Datu Paglas", "New Bataan", "Surigao City",
        "Malita", "Zamboanga del Norte (Dipolog City)", "Zamboanga del Sur (Pagadian City)", "Labason",
        "Bacolod (Lanao del Norte)", "Maramag", "Kapatagan", "Midsayap", "Sultan Kudarat (Tacurong)", 
        "Sultan Kudarat (Columbio)", "Sultan Kudarat (Bagumbayan)", "Sultan Kudarat (Esperanza)",
        "Zamboanga del Norte (Polanco)", "Zamboanga del Norte (Godod)", "Zamboanga del Sur (Mahayag)",
        "Zamboanga del Sur (Aurora)", "Sibuco", "Lake Sebu", "Sultan Kudarat (Tacurong)", "Midsayap"
    ]
};

    function updatePositions() {
        const industrySelect = document.getElementById('industry');
        const positionSelect = document.getElementById('position');
        const selectedIndustry = industrySelect.value;

        // Clear previous options
        positionSelect.innerHTML = '<option value="">Select Position</option>';

        if (selectedIndustry && positionsByIndustry[selectedIndustry]) {
            positionsByIndustry[selectedIndustry].forEach(position => {
                const option = document.createElement('option');
                option.value = position;
                option.textContent = position;
                positionSelect.appendChild(option);
            });
        }
    }

    function updateCities() {
        const regionSelect = document.getElementById('region');
        const citySelect = document.getElementById('city');
        const selectedRegion = regionSelect.value;

        // Clear previous options
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (selectedRegion && citiesByRegion[selectedRegion]) {
            citiesByRegion[selectedRegion].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    }
    </script>
    
    <script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const toggleText = document.getElementById('togglePassword');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleText.textContent = 'Hide'; // Change text to "Hide"
        } else {
            passwordField.type = 'password';
            toggleText.textContent = 'Show'; // Change text back to "Show"
        }
    }
</script>
</body>
</html>
