<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbizio | Connecting Talent With Opportunity</title>
    <link rel="icon" href="assets/logoserbizio.png" type="image/x-icon">
    <meta name="description" content="Serbizio is a digital manpower provider connecting families with skilled domestic help through an online platform.">
    <meta property="og:title" content="Serbizio | Connecting Talent With Opportunity">
    <meta property="og:description" content="Serbizio is a digital manpower provider connecting families with skilled domestic help through an online platform.">
    <meta property="og:image" content="assets/logoserbizio.png">
    <meta property="og:url" content="https://techproject.cloud/serbizio">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

body {
    font-family: 'Roboto', Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    color: #1a1a1a; /* White text for contrast */
    background-color: #f1f1f1; /* Black background */
}

header, footer {
    background-color: #f1f1f1; /* Dark gray for header/footer */
    color: #1a1a1a; 
    text-align: center;
    padding: 1em 0;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

header::after, footer::after {
    content: '';
    background-size: 50px;
    position: absolute;
    top: 50%;
    left: 0;
    width: 50px;
    height: 50px;
    transform: translateY(-50%);
}

header::after {
    left: calc(100% - 50px);
}

.banner {
    background: url('assets/serbiziobg.png') no-repeat center center;
    background-size: cover;
    height: 600px; /* Default height for mobile screens */
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    font-size: 3em;
    font-weight: bold;
    animation: fadeIn 2s;
    position: relative;
    overflow: hidden;
}

/* Media query for desktop screens */
@media (min-width: 768px) {
    .banner {
        height: 600px; /* Adjust height for larger screens as needed */
        font-size: 4em; /* Adjust font size for better visibility on larger screens */
    }
}
/* Media query for mobile screens */
@media (max-width: 768px) {
    .banner {
        height: 150px; /* Adjust height for larger screens as needed */
        font-size: 4em; /* Adjust font size for better visibility on larger screens */
    }
}


.banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.banner div {
    position: relative;
    z-index: 2;
}

.container {
    padding: 40px 20px;
    animation: fadeInUp 2s;
}

.section-title {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2em;
    color: #3a7bd5; /* Pastel blue */
    border-bottom: 2px solid #e1e1e1; /* Underline effect */
    padding-bottom: 10px;
    display: inline-block;
}

section {
    padding: 40px 20px; /* Added padding for all sections */
}

.about, .services, .ceo, .contact, .individual-contractor, .partner-agencies {
    margin: 40px 0;
}

.card-body {
    background: white;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    padding: 25px;
    animation: fadeInUp 1.5s;
    text-align: justify; /* Justify text within card bodies */
}

/* Justify text within specific sections */
.about p, .services p, .ceo p, .contact form, .individual-contractor p, .partner-agencies p {
    text-align: justify;
}

.services {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.service-item {
    background: white;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 300px;
    transition: transform 0.3s, box-shadow 0.3s;
    animation: fadeInUp 1.5s;
    position: relative;
    overflow: hidden;
}

.service-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
}

.service-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.service-item-content {
    padding: 20px;
}

.service-item h3 {
    margin-top: 0;
    color: #3a7bd5; /* Pastel blue */
    font-size: 1.5em;
}
.service-item p {
    
    color: #1a1a1a; /* Pastel blue */
    
}

.contact form {
    display: flex;
    flex-direction: column;
    text-align: center; /* Center-align form elements */
}

.contact form input, .contact form textarea {
    margin-bottom: 15px;
    padding: 15px;
    font-size: 1em;
    border: 1px solid #a3c2f2; /* Pastel blue border */
    border-radius: 8px;
}

.contact form button {
    padding: 15px;
    font-size: 1em;
    background-color: #3a7bd5; /* Pastel blue */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.contact form button:hover {
    background-color: #2c6bd0; /* Slightly darker blue */
    transform: translateY(-2px);
}

.footer-links {
    /*display: flex;*/
    /*justify-content: space-around;*/
    /*padding: 15px 0;*/
    animation: fadeInUp 1.5s;
}

.footer-links a {
    color: #1a1a1a; /* White */
    text-decoration: none;
    font-size: 1em;
    padding: 10px; /* Added padding */
}

.footer-links a:hover {
    text-decoration: underline;
    color: #3a7bd5; /* Light blue */
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.ceo-carousel {
    position: relative;
    overflow: hidden;
    margin: 40px 0;
    padding: 20px; /* Added padding */
}

.carousel {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.carousel-slides {
    display: flex;
    transition: transform 0.5s ease;
}

.carousel-slide {
    min-width: 100%;
    box-sizing: border-box;
    text-align: center;
    padding: 20px; /* Added padding */
}

.carousel-slide img {
    width: 100px; /* Set the width of the image */
    height: 100px; /* Set the height of the image */
    border-radius: 50%; /* Make the image circular */
    object-fit: cover; /* Ensure the image covers the circle */
    margin-bottom: 20px; /* Space between the image and text */
}

.carousel-slide p {
    margin: 20px 0;
    font-size: 1.2em;
}

/*.carousel-prev, .carousel-next {*/
/*    position: absolute;*/
/*    top: 50%;*/
/*    transform: translateY(-50%);*/
    background-color: transparent; /* White background color */
    color: black; /* Text color for visibility */
    border: 2px solid black; /* Border for better definition */
    border-radius: 50%; /* Circular shape */
    width: 40px; /* Width of the button */
    height: 40px; /* Height of the button */
/*    display: flex;*/
/*    align-items: center;*/
/*    justify-content: center;*/
/*    font-size: 1.5em;*/
/*    cursor: pointer;*/
    z-index: 10; /* Ensure buttons are above other elements */
/*}*/

.carousel-prev {
    left: 10px;
}

.carousel-next {
    right: 10px;
}



    </style>
    
    <style>
        .download-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .download-button:hover {
            background-color: #0056b3;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 160px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        html {
    scroll-behavior: smooth;
}
.button {
    display: inline-block;
    padding: 10px 20px; /* Adjust padding as needed */
    font-size: 16px; /* Adjust font size as needed */
    font-weight: bold;
    color: white;
    background-color: #007bff; /* Button background color */
    border: none;
    border-radius: 5px; /* Rounded corners */
    text-align: center;
    text-decoration: none; /* Remove underline from link */
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.button:hover {
    background-color: #0056b3; /* Darker color on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

.button:active {
    background-color: #004494; /* Even darker color when button is clicked */
    transform: scale(1); /* Ensure button scales back when clicked */
}


.partner-image {
    width: 100%; /* Default to full width */
    height: auto; /* Maintain aspect ratio */
    max-width: 800px; /* Maximum width */
    margin: 20px auto; /* Center-align with margin */
    display: block; /* Ensure the image is a block element */
}

@media (max-width: 768px) {
    .partner-image {
        max-width: 100%; /* Full width on small screens */
        height: auto; /* Maintain aspect ratio */
    }
}

.services {
    padding: 20px;
    text-align: center;
}

.section-title {
    margin-bottom: 30px;
    font-size: 2em;
}

.service-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.service-card {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 250px; /* Adjust width as needed */
    transition: transform 0.3s;
}

.service-card:hover {
    transform: translateY(-5px);
}

.service-icon {
    font-size: 3em;
    color: #4CAF50; /* Adjust color as needed */
    margin-bottom: 15px;
}

.service-title {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.service-description {
    font-size: 1em;
    color: #1a1a1a;
}


nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #a3c2f2; /* Change to your preferred color */
    padding: 10px;
}

#menu-icon {
    cursor: pointer;
    font-size: 24px;
    color: white; /* Change to your preferred color */
}

#nav-links {
    display: none; /* Initially hidden */
    list-style: none;
    padding: 0;
    margin: 0;
    flex-direction: column;
    align-items: center;
}

@media (min-width: 769px) {
    #nav-links {
        display: flex; /* Show on larger screens */
        flex-direction: row;
    }
}

@media (max-width: 768px) {
    #nav-links {
        display: none; /* Initially hidden on mobile */
        flex-direction: row; /* Arrange links in a row */
        background-color: #a3c2f2; /* Match nav background color */
        left: 0;
        width: 100%; /* Full width for dropdown */
        justify-content: center; /* Center links horizontally */
    }

    #menu-icon {
        cursor: pointer;
        font-size: 20px;
        color: white; /* White menu icon */
    }

    #menu-icon.active + #nav-links {
        display: flex; /* Show links when menu icon is active */
    }
}

#nav-links li {
    margin: 0 10px; /* Adjust spacing between links */
}
.apk-download {
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
}

.apk-links {
    display: flex;
    justify-content: space-between;
}

.apk-links div {
    width: 48%; /* Adjust width as needed */
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.download-button {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.download-button:hover {
    background-color: #0056b3;
}
.apk-image {
    width: 200px; /* Default size for larger screens */
    height: auto; /* Maintain aspect ratio */
}

@media (max-width: 600px) { /* Adjust for mobile screens */
    .apk-image {
        width: 150px; /* Reduce size on mobile */
    }
}

     
    </style>
</head>
<body>

<!--<header>-->
<!--    <nav>-->
<!--        <div id="menu-icon" style="cursor: pointer; font-size: 24px; color: white;">&#9776;</div>-->
<!--        <ul id="nav-links">-->
            
<!--            <li style="margin: 0 15px;"><a href="#about" style="color: white; text-decoration: none; font-weight: bold;">About Us</a></li>-->
<!--            <li style="margin: 0 15px;"><a href="#services" style="color: white; text-decoration: none; font-weight: bold;">Services</a></li>-->
<!--            <li style="margin: 0 15px;"><a href="#ceo" style="color: white; text-decoration: none; font-weight: bold;">CEO Message</a></li>-->
<!--            <li style="margin: 0 15px;"><a href="#contact" style="color: white; text-decoration: none; font-weight: bold;">Contact</a></li>-->
<!--        </ul>-->
        
        
<!--    </nav>-->
<!--</header>-->


<div class="banner">
    <div></div>
</div>

<div class="container">
    <section class="about" id="about">
        
            <h2 class="section-title">Who We Are</h2>
            <p>Serbizio is a digital manpower provider that aims to provide clients with domestic workers qualified to undertake household duties. The company is the first in the Philippines to utilize an online app to connect families with skilled domestic help tailored to suit their specific needs. By leveraging technology, we streamline the process of hiring, training, and managing household workers ensuring convenience, reliability, and quality service for our clients.</p>
            <p>Our platform allows users to browse, search, and book professionals trained in various tasks, including cleaning, cooking, babysitting, elderly & pet care. The date and information of selected individuals is guaranteed accurate with a thorough background check by the company. Each worker is trained and reviewed to meet the highest standards of service, providing safety and exceptional care for your home and family.</p>
            <p>At Serbizio, we are determined to change the face of domestic employment by incorporating cutting-edge technology, extensive training programs, and a user-friendly interface. Our aim is not only restricted to serving our customers but also cherishing lives by creating a supportive working environment that caters for the changing requirements of today’s homes.</p>
        
    </section>

    <section class="services" id="services">
    <h2 class="section-title">Our Main Services</h2>
    <div class="service-item">
        <img src="assets/maid.webp" alt="Maid">
        <div class="service-item-content">
            <h3>Household Services</h3>
            <p>Expert services to help maintain your home, including cleaning, laundry, and domestic assistance to keep your household running smoothly.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/driver.webp" alt="Driver">
        <div class="service-item-content">
            <h3>Transportation Services</h3>
            <p>Reliable drivers and transport solutions to get you to your destination safely and on time.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/elderly.jpg" alt="Elderly Caregiver">
        <div class="service-item-content">
            <h3>Personal Services</h3>
            <p>Personalized care services such as nannies, elderly caregivers, and personal cooks to meet your daily living and personal needs.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/call-center-agent.jpg" alt="Call Center Agent">
        <div class="service-item-content">
            <h3>BPO Services</h3>
            <p>Comprehensive business process outsourcing services, including customer support, technical assistance, and back-office operations.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/chef.jpg" alt="Chef">
        <div class="service-item-content">
            <h3>Restaurant Services</h3>
            <p>Skilled professionals in the food and beverage industry, from chefs to waitstaff, providing exceptional dining experiences.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/construction.jpg" alt="Construction Worker">
        <div class="service-item-content">
            <h3>Construction Services</h3>
            <p>Quality construction and maintenance services, including carpentry, plumbing, electrical work, and renovation projects.</p>
        </div>
    </div>
    <div class="service-item">
        <img src="assets/factory.jpg" alt="Factory Worker">
        <div class="service-item-content">
            <h3>General Services</h3>
            <p>A wide range of essential services to meet everyday needs, including maintenance, repair, and other specialized tasks to make life easier.</p>
        </div>
    </div>
</section>



    <section class="ceo-carousel" id="ceo">
    <h2 class="section-title">Message from the CEO</h2>
   <div class="carousel">
    <div class="carousel-slides">
        <div class="carousel-slide">
            <img src="assets/sean.png" alt="Message from CEO 1">
            <p>"At Serbizio, we strive to offer the best domestic help services that cater to the unique needs of every household. Our mission is to ensure that every family has access to reliable, skilled, and trustworthy professionals to help them manage their daily tasks efficiently."</p>
            <p>- <strong>Sean Walden Reyes</strong>, CEO</p>
        </div>
        <div class="carousel-slide">
            <img src="assets/julio.jpg" alt="Message from CEO 2">
            <p>"We are committed to innovation, excellence, and providing exceptional value to our clients. Our team is dedicated to ensuring that our services not only meet but exceed your expectations, making your home life more manageable and enjoyable."</p>
            <p>- <strong>Julius Alexander Reyes</strong>, CEO</p>
        </div>
        <div class="carousel-slide">
            <img src="assets/casey.png" alt="Message from CEO 3">
            <p>"Thank you for choosing Serbizio as your trusted partner in managing household tasks. We are continually evolving to offer the best solutions for your needs, and we appreciate your support and feedback as we grow."</p>
            <p>- <strong>Casey Dowling</strong>, CEO</p>
        </div>
    </div>
    <div class="carousel-prev"></div>
    <div class="carousel-next"></div>
</div>

</section>


    

    <section class="individual-contractor">
    <h2 class="section-title">For Individual Contractors</h2>
    <img src="assets/worker.png" alt="Individual Contractor" class="partner-image">
    <p>If you're a talented individual looking for opportunities to showcase your skills and provide valuable services to families in need, we invite you to join our platform today. Serbizio offers a range of domestic work opportunities tailored to various expertise, from cooking and cleaning to childcare and elderly care. By joining our network, you'll gain access to a wide range of job opportunities and have the chance to work with clients who value your skills and dedication.</p>
    <p>Our platform is designed to connect skilled professionals with families seeking reliable domestic help. We provide a user-friendly interface that makes it easy for you to apply for jobs, manage your schedule, and communicate with clients. Apply now to become a part of our professional network and start making a meaningful difference in people's lives. We look forward to welcoming you to Serbizio!</p>
    <a href="individual_contractor_form.php" class="button">Apply Now</a>

</section>

<section class="partner-agencies">
    <h2 class="section-title">For Partner Agencies</h2>
    <img src="assets/agencies.png" alt="Partner Agencies" class="partner-image">
    <p>Are you an agency specializing in domestic services? Partnering with Serbizio offers you a unique opportunity to expand your reach and connect with a broader client base. Our platform provides a comprehensive solution for managing household services, including tools for client matching, scheduling, and service management. By collaborating with us, you can enhance your agency’s visibility and grow your business.</p>
    <p>We are looking for reliable and reputable agencies to join our network and help us deliver exceptional service to families across the region. Our partnership program is designed to support your agency’s growth while ensuring that our clients receive top-notch service. Get in touch with us to learn more about how we can work together to achieve our common goals. Together, we can create a stronger network and deliver unparalleled service to our clients.</p>
    <a href="partner_agency_form.php" class="button">Partner With Us</a>
</section>

 <button id="upBtn" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 100; background-color: #007bff; color: white; border: none; border-radius: 5px; padding: 10px;">↑</button>


<section class="download" id="download">
    <h2 class="section-title">Download Our Apps</h2>
    <p>Choose the appropriate app for your needs and download the latest version.</p>

    <div class="apk-download">
        <div class="apk-card">
            <h3>Client App</h3>
            <p>Download the Client App to access our services conveniently.</p>
            <a href="app/serbizioclient1.0.3.apk" class="download-btn" download>
                <img src="assets/apps_android.png" alt="Download Client APK" class="apk-image">
            </a>
        </div>

        <div class="apk-card">
            <h3>Service Provider App</h3>
            <p>Download the Service Provider App to manage your services on the go.</p>
            <a href="app/serbizioprovider1.0.2.apk" class="download-btn" download>
                <img src="assets/android-app.gif" alt="Download Service Provider APK" class="apk-image">
            </a>
        </div>
    </div>
</section>

    
    <section class="contact" id="contact">
        
            <h2 class="section-title">Contact Us</h2>
            <form action="contact_form_handler.php" method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        
    </section>
    
    
   
    
</div>

<footer>
    <div class="footer-links">
        
        <a href="privacy_policy.html">Privacy Policy</a> |
        <a href="cancellation_policy.html">Cancellation Policy</a> |
        <a href="terms_of_service.html">Terms of Service</a> |
        <a href="complaints_form.php">Submit a Complaint</a> <!-- Add this line -->
    </div>
    <p>&copy; 2024 Serbizio. All rights reserved.</p>
</footer>
<script>
// Get the button
let upBtn = document.getElementById("upBtn");

// Show the button when the user scrolls down 100px from the top
window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        upBtn.style.display = "block";
    } else {
        upBtn.style.display = "none";
    }
};

// When the user clicks on the button, scroll to the top of the document
upBtn.onclick = function() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
};
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    const slides = document.querySelector('.carousel-slides');
    let index = 0;

    function showSlide(newIndex) {
        const slidesCount = document.querySelectorAll('.carousel-slide').length;
        if (newIndex >= slidesCount) {
            index = 0;
        } else if (newIndex < 0) {
            index = slidesCount - 1;
        } else {
            index = newIndex;
        }
        slides.style.transform = `translateX(-${index * 100}%)`;
    }

    prevButton.addEventListener('click', function() {
        showSlide(index - 1);
    });

    nextButton.addEventListener('click', function() {
        showSlide(index + 1);
    });

    // Optional: Auto-slide functionality
    setInterval(function() {
        showSlide(index + 1);
    }, 5000); // Change slide every 5 seconds
});
</script>

<script>
    document.getElementById("menu-icon").onclick = function() {
        const navLinks = document.getElementById("nav-links");
        if (navLinks.style.display === "none" || navLinks.style.display === "") {
            navLinks.style.display = "flex"; // Show the menu
        } else {
            navLinks.style.display = "none"; // Hide the menu
        }
    };
</script>


</body>
</html>
