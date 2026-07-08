<?php
session_start();

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

// 📊 ඩේටාබේස් එකෙන් Counts ලබා ගැනීම
// 1. ලියාපදිංචි දායකයන් ගණන (Registered Donors)
$donor_count = 0;
$donor_res = $conn->query("SELECT COUNT(*) AS total_donors FROM donor");
if($donor_res) {
    $donor_row = $donor_res->fetch_assoc();
    $donor_count = $donor_row['total_donors'];
}

// 2. බේරාගත් ජීවිත ගණන (Lives Saved = Total Blood Released Units)
$lives_saved = 0;
$release_res = $conn->query("SELECT SUM(units) AS total_released FROM blood_releases");
if($release_res) {
    $release_row = $release_res->fetch_assoc();
    // තවම කිසිවක් රිලීස් කර නැත්නම් 0 පෙන්වීමට null coalescing (?? 0) භාවිත කර ඇත
    $lives_saved = $release_row['total_released'] ?? 0; 
}

// 3. ලේ දීමේ කඳවුරු ගණන (Donation Camps)
$camp_count = 0;
$camp_res = $conn->query("SELECT COUNT(*) AS total_camps FROM campaigns");
if($camp_res) {
    $camp_row = $camp_res->fetch_assoc();
    $camp_count = $camp_row['total_camps'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Blood Donation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .top-bar{
            background: #8e0000;
            padding: 10px 30px;
            text-align: right;
        }
        .top-bara{
            text-align: center;
        }
        .hero{
            background: linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
            background-size: cover;
            color: white;
            text-align: center;
            padding: 80px 20px;
        }
        .nav-buttons .btn{
            margin: 8px;
        }
        .section-box{
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px #ccc;
            margin-bottom: 30px;
        }
        .section-box h2{
            color: #c0392b;
        }
        .counter-box{
            background: #fdecea;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }
        .team-card{
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        footer{
            background: #8e0000;
            color: white;
            padding: 40px 20px;
            margin-top: 50px;
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
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr>
    <h1 class="mt-5">About Blood Donation Sri Lanka</h1>
    <p>Saving Lives Through Technology & Community Support</p>
</div>

<div class="container py-5">

    <div class="section-box">
        <h2>Who We Are</h2>
        <p>
            Our Online Blood Donation System is designed to connect blood donors with hospitals and patients across Sri Lanka. 
            We aim to reduce blood shortages and create a reliable emergency support network.
        </p>
    </div>

    <div class="section-box">
        <h2>Our Objectives</h2>
        <ul>
            <li>✔ Increase blood donor awareness</li>
            <li>✔ Help hospitals find blood quickly</li>
            <li>✔ Organize donation campaigns</li>
            <li>✔ Encourage youth participation</li>
            <li>✔ Save lives using modern technology</li>
        </ul>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="counter-box">
                <h1 class="display-4 fw-bold text-danger"><?php echo number_format($donor_count); ?></h1>
                <p class="fw-bold text-secondary mb-0">Registered Donors</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="counter-box">
                <h1 class="display-4 fw-bold text-success"><?php echo number_format($lives_saved); ?>+</h1>
                <p class="fw-bold text-secondary mb-0">Lives Saved (Units Released)</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="counter-box">
                <h1 class="display-4 fw-bold text-primary"><?php echo number_format($camp_count); ?></h1>
                <p class="fw-bold text-secondary mb-0">Donation Campaigns</p>
            </div>
        </div>
    </div>

    <div class="section-box mt-5">
        <h2>Our Team</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="team-card">
                    <img src="images/team1.jpg" class="img-fluid rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                    <h5>Dr. Nimal Perera</h5>
                    <p class="text-muted">Chief Medical Advisor</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card">
                    <img src="images/team2.jpg" class="img-fluid rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                    <h5>Kasuni Silva</h5>
                    <p class="text-muted">Campaign Coordinator</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card">
                    <img src="images/team3.jpg" class="img-fluid rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                    <h5>Ishani Sandarekha</h5>
                    <p class="text-muted">Technical Manager</p>
                </div>
            </div>
        </div>
    </div>

</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>About Us</h4>
                <p>Blood Donation System Sri Lanka connects donors and patients efficiently.</p>
            </div>
            <div class="col-md-4">
                <h4>Quick Links</h4>
                <a href="Services.php" class="text-white d-block mb-1">Services</a>
                <a href="donor.php" class="text-white d-block mb-1">Donors</a>
                <a href="evnts.php" class="text-white d-block mb-1">Events</a>
            </div>
            <div class="col-md-4">
                <h4>Contact</h4>
                <p class="mb-1">Email: sandarekaishani83@gmail.com</p>
                <p class="mb-0">Phone: +94782314518</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>