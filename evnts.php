<?php
session_start();

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

// 📊 ඩේටාබේස් එකෙන් බේරාගත් මුළු ජීවිත ගණන (Lives Saved = SUM(units)) ලබා ගැනීම
$db_lives = 0;
$release_res = $conn->query("SELECT SUM(units) AS total_released FROM blood_releases");
if($release_res) {
    $release_row = $release_res->fetch_assoc();
    $db_lives = $release_row['total_released'] ?? 0; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events & News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* TOP BAR */
        .top-bar{
            background: #8e0000;
            padding: 10px 30px;
            text-align: right;
        }
        .top-bara{
            text-align: center;
        }

        /* HERO */
        .hero{
            background: linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 20px;
            text-align: center;
        }
        .hero h1{
            font-size: 55px;
            font-weight: bold;
        }
        .nav-buttons .btn{
            margin: 8px;
            font-weight: bold;
        }

        /* SECTION */
        .section{
            padding: 60px 20px;
        }
        .section-title{
            text-align: center;
            color: #c0392b;
            font-weight: bold;
            margin-bottom: 50px;
        }

        /* CARDS */
        .event-card{
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
            height: 100%;
            box-shadow: 0 0 10px #ddd;
        }
        .event-card:hover{
            transform: translateY(-8px);
        }
        .event-card img{
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .event-body{
            padding: 25px;
        }
        .event-body h4{
            color: #c0392b;
            font-weight: bold;
        }

        /* ALERT */
        .alert-box{
            background: #fff3f3;
            border-left: 8px solid red;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 10px #ddd;
        }

        /* COUNTER */
        .counter-box{
            background: #c0392b;
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
        }
        .counter-box h1{
            font-size: 60px;
            font-weight: bold;
        }

        /* ARTICLE */
        .article-card{
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 0 10px #ddd;
            height: 100%;
        }

        /* AWARDS */
        .award-card{
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 10px #ddd;
        }
        .award-card img{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        /* FOOTER */
        footer{
            background: #8e0000;
            color: white;
            padding: 40px 20px;
        }
        footer a{
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="top-bar d-flex align-items-center justify-content-between flex-wrap">
    
    <div class="text-start order-1">
        <a href="profile.php" class="btn btn-light btn-sm fw-bold shadow-sm px-3">👤 Profile</a>
    </div>    

    <div class="top-bara order-2 my-2">
        <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:120px; height:120px; object-fit:cover;">
    </div>

    <div class="text-end order-3">
        <a href="login.php" class="btn btn-light btn-sm fw-bold shadow-sm px-3">Log Out</a>
    </div>  
    
</div>

<div class="hero">
    <div class="nav-buttons">
        <a href="Dashboard.php" class="btn btn-light">Dashboard</a>
        <a href="Services.php" class="btn btn-light">Services</a>
        <a href="donor.php" class="btn btn-light">Donors</a>
        <a href="evnts.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr>
    <br><br><br>
    <h1>
         <a href="donor_rejiststion.php" class="btn btn-light btn-lg fw-bold text-danger">Register as a Donor</a>
    </h1>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Upcoming Mobile Blood Donation Camps</h1>
        <div class="row g-4">
    <div class="col-md-4">
        <div class="event-card">
            <img src="images/event1.jpg" alt="Colombo Camp">
            <div class="event-body">
                <h4>Colombo Blood Camp</h4>
                <p>📅 2026 May 15</p>
                <p>🕒 9.00 AM - 4.00 PM</p>
                <p>📍 Colombo Town Hall</p>
                <p>🏢 Organized by National Blood Bank</p>
                <a href="https://www.google.com/maps/dir/?api=1&destination=Colombo+Town+Hall" target="_blank" class="btn btn-danger w-100 mb-2">View Direction</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="event-card">
            <img src="images/event2.jpg" alt="Kandy Camp">
            <div class="event-body">
                <h4>Kandy Donation Drive</h4>
                <p>📅 2026 May 22</p>
                <p>🕒 8.00 AM - 3.00 PM</p>
                <p>📍 Kandy Hospital Ground</p>
                <p>🏢 Organized by Red Cross</p>
                <a href="https://www.google.com/maps/dir/?api=1&destination=Kandy+General+Hospital" target="_blank" class="btn btn-danger w-100 mb-2">View Direction</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="event-card">
            <img src="images/event3.jpg" alt="Galle Camp">
            <div class="event-body">
                <h4>Galle Youth Event</h4>
                <p>📅 2026 June 05</p>
                <p>🕒 9.00 AM - 2.00 PM</p>
                <p>📍 Galle City Hall</p>
                <p>🏢 Organized by Youth Society</p>
                <a href="https://www.google.com/maps/dir/?api=1&destination=Galle+City+Hall" target="_blank" class="btn btn-danger w-100 mb-2">View Direction</a>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Urgent Blood Shortage Alerts</h1>
        <div class="alert-box">
            <h3 class="text-danger fw-bold">🚨 Blood Urgently Needed</h3>
            <p>Certain blood types are running extremely low in our central storage. If you are eligible, please schedule an appointment immediately.</p>
            <a href="book_blood.php" class="btn btn-danger fw-bold">Book Now</a>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Success Stories & Impact Metrics</h1>
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Successful Blood Donation Campaign</h4>
                    <p class="mt-3">
                        Last week's blood donation campaign successfully collected over 50 liters of blood and helped save many lives across Sri Lanka. Thank you to all the noble donors who participated.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="counter-box">
                    <h1 id="counter">0</h1>
                    <h4>Lives Saved</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Awareness Articles & Health Tips</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Before Donating Blood</h4>
                    <p>Drink plenty of water and eat healthy meals before donating blood.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Benefits of Blood Donation</h4>
                    <p>Blood donation improves blood circulation and helps maintain heart health.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Blood Groups Information</h4>
                    <p>Learn about compatible blood groups and emergency donation requirements.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Special Appreciations & Awards</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event.jpg" alt="Donor">
                    <h4 class="text-danger fw-bold">Donor of the Month</h4>
                    <p class="mb-1"><strong>Kasun Perera</strong></p>
                    <p class="text-muted small mb-0">25 Successful Donations</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event1.jpg" alt="Volunteer">
                    <h4 class="text-danger fw-bold">Best Volunteer Team</h4>
                    <p class="mb-1"><strong>Colombo Youth Group</strong></p>
                    <p class="text-muted small mb-0">10 Successful Campaigns</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event3.jpg" alt="Community">
                    <h4 class="text-danger fw-bold">Top Organizing Community</h4>
                    <p class="mb-1"><strong>Kandy Community Society</strong></p>
                    <p class="text-muted small mb-0">500+ Blood Donations</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h4>About Us</h4>
                <p>Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently to save lives.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h4>Quick Links</h4>
                <a href="Services.php">Services</a>
                <a href="donor.php">Donors</a>
                <a href="evnts.php">Events & News</a>
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="col-md-4 mb-3">
                <h4>Contact</h4>
                <p class="mb-1">Email: sandarekaishani83@gmail.com</p>
                <p class="mb-0">Phone: +94782314518</p>
            </div>
        </div>
    </div>
</footer>

<script>
// Database එකෙන් ලැබෙන අගය ලබා ගැනීම
const targetValue = <?php echo $db_lives; ?>;

function animateCounter(elementId, target, duration) {
    let obj = document.getElementById(elementId);
    if (target === 0) {
        obj.innerHTML = "0";
        return;
    }
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * target).toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// පිටුව Load වූ පසු Animation එක පටන් ගැනීම
window.addEventListener('DOMContentLoaded', () => {
    animateCounter("counter", targetValue, 1500); // මිලිසෙකන්ඩ් 1500 ක කාලයක් තුල සිදුවේ
});
</script>

</body>
</html>