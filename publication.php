<?php
session_start();

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

//  (Registered Donors) ganana
$db_donors = 0;
$donor_res = $conn->query("SELECT COUNT(*) AS total_donors FROM donor");
if($donor_res) {
    $donor_row = $donor_res->fetch_assoc();
    $db_donors = $donor_row['total_donors'];
}

//  (Lives Saved = Total Blood Released Units)
$db_lives = 0;
$release_res = $conn->query("SELECT SUM(units) AS total_released FROM blood_releases");
if($release_res) {
    $release_row = $release_res->fetch_assoc();
    $db_lives = $release_row['total_released'] ?? 0; 
}

// (Donation Camps)
$db_camps = 0;
$camp_res = $conn->query("SELECT COUNT(*) AS total_camps FROM campaigns");
if($camp_res) {
    $camp_row = $camp_res->fetch_assoc();
    $db_camps = $camp_row['total_camps'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Publications - Blood Donation System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
}
/* Top Bar */
.top-bar{
    background: #8e0000;
    padding: 10px 30px;
    text-align: right;
}
.top-bara{
    text-align: center;
}
/* Hero Section */
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
.hero p{
    font-size: 22px;
}
/* Navigation */
.nav-buttons .btn{
    margin: 8px;
    font-weight: bold;
}
/* Sections */
.section-title{
    color: #8e0000;
    font-weight: bold;
    margin-bottom: 30px;
}
/* Cards */
.pub-card{
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 0 10px #ddd;
    height: 100%;
    transition: 0.3s;
}
.pub-card:hover{
    transform: translateY(-5px);
}
.pub-card img{
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 10px;
}
.pub-card h4{
    margin-top: 15px;
    color: #c0392b;
}
/* Counter */
.counter-section{
    background: #fdecea;
    padding: 60px 20px;
    text-align: center;
}
.counter-box{
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 10px #ddd;
}
.counter-box h1{
    font-size: 60px;
    color: #c0392b;
    font-weight: bold;
}
/* Awareness */
.awareness-box{
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 10px #ddd;
    margin-bottom: 20px;
}
/* Footer */
footer{
    background: #8e0000;
    color: white;
    padding: 40px 20px;
}
footer h4{
    margin-bottom: 20px;
}
footer a{
    color: white;
    text-decoration: none;
    display: block;
    margin-bottom: 10px;
}
footer a:hover{
    text-decoration: underline;
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
        <a href="publication.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr>
    <br><br>
    <a href="donor_rejiststion.php" class="btn btn-light btn-lg fw-bold text-danger">Register as a Donor</a>
</div>

<br>
<div class="text-center">
    <h1 class="fw-bold">Blood Donation Publications</h1>
    <p class="text-muted fs-5">Awareness Articles, Research Reports & Success Stories</p>
</div>
<br>

<div class="container mt-5 mb-5">
    <h2 class="text-center section-title">Latest Publications</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="pub-card">
                <img src="images/k.jpg" alt="Benefits">
                <h4>Benefits of Blood Donation</h4>
                <p>Regular blood donation improves blood circulation and helps save lives. Learn about the health benefits of donating blood regularly.</p>
                <a href="images/benifits of blood donation.pdf" class="btn btn-danger w-100 mt-2">Read More</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pub-card">
                <img src="images/l.jpg" alt="Awareness">
                <h4>Blood Donation Awareness Guide</h4>
                <p>Important information about who can donate blood, preparation tips, and post-donation care instructions.</p>
                <a href="images/Blood Donation Awareness Guide.pdf" class="btn btn-danger w-100 mt-2">Read More</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pub-card">
                <img src="images/j.jpg" alt="Campaign">
                <h4>Emergency Blood Campaign Report</h4>
                <p>Summary of emergency blood donation campaigns conducted across Sri Lanka during the last month.</p>
                <a href="images/Emergency Blood Campaign Report.pdf" class="btn btn-danger w-100 mt-2">Read More</a>
            </div>
        </div>
    </div>
</div>

<div class="counter-section">
    <div class="container">
        <h2 class="section-title text-dark">Impact Statistics</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="counter-box">
                    <h1 id="donors">0</h1>
                    <h4 class="text-secondary">Registered Donors</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="counter-box">
                    <h1 id="lives">0</h1>
                    <h4 class="text-secondary">Lives Saved</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="counter-box">
                    <h1 id="camps">0</h1>
                    <h4 class="text-secondary">Blood Camps Organized</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <h2 class="text-center section-title">Health Tips & Awareness Articles</h2>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="awareness-box h-100">
                <h4 class="text-danger fw-bold mb-3">Before Donating Blood</h4>
                <ul>
                    <li class="mb-2">Drink plenty of water.</li>
                    <li class="mb-2">Eat healthy food before donation.</li>
                    <li class="mb-2">Get enough sleep the night before.</li>
                    <li class="mb-2">Avoid smoking and alcohol.</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="awareness-box h-100">
                <h4 class="text-danger fw-bold mb-3">After Donating Blood</h4>
                <ul>
                    <li class="mb-2">Take rest for 10-15 minutes.</li>
                    <li class="mb-2">Drink fruit juice or water.</li>
                    <li class="mb-2">Avoid heavy exercise for one day.</li>
                    <li class="mb-2">Eat iron-rich foods.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h2 class="text-center section-title">Special Appreciations & Awards</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="pub-card text-center">
                <img src="images/h.jpg" alt="Donor Month">
                <h4>Donor of the Month</h4>
                <p class="text-muted">Mr. Kasun Perera donated blood 15 times this year and helped save many lives.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pub-card text-center">
                <img src="images/y.jpg" alt="Community">
                <h4>Top Organizing Community</h4>
                <p class="text-muted">Kandy Youth Association successfully organized 10 blood donation camps.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pub-card text-center">
                <img src="images/t.jpg" alt="Volunteer">
                <h4>Volunteer Appreciation</h4>
                <p class="text-muted">Special thanks to all volunteers supporting our national blood donation campaigns.</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h2 class="text-center section-title">Download Publications</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="pub-card text-center d-flex flex-column justify-content-between">
                <div>
                    <h4>Annual Report 2025</h4>
                    <p class="text-muted small">Blood donation annual statistics report.</p>
                </div>
                <a href="images/Annual Report 2025.pdf" class="btn btn-danger w-100">Download PDF</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pub-card text-center d-flex flex-column justify-content-between">
                <div>
                    <h4>Health Guide</h4>
                    <p class="text-muted small">Guide for healthy blood donation habits.</p>
                </div>
                <a href="images/Health Guide.pdf" class="btn btn-danger w-100">Download PDF</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pub-card text-center d-flex flex-column justify-content-between">
                <div>
                    <h4>Research Paper</h4>
                    <p class="text-muted small">Research about blood donation awareness.</p>
                </div>
                <a href="images/Research Paper.pdf" class="btn btn-danger w-100">Download PDF</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="pub-card text-center d-flex flex-column justify-content-between">
                <div>
                    <h4>Campaign Magazine</h4>
                    <p class="text-muted small">Monthly publication of blood donation events.</p>
                </div>
                <a href="images/Campaign Magazine.pdf" class="btn btn-danger w-100">Download PDF</a>
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
// PHP walin labena saba data gann eka
const maxDonors = <?php echo $db_donors; ?>;
const maxLives = <?php echo $db_lives; ?>;
const maxCamps = <?php echo $db_camps; ?>;

//  Counting Animation ek karana Function 
function animateCounter(elementId, targetValue, duration) {
    let obj = document.getElementById(elementId);
    if (targetValue === 0) {
        obj.innerHTML = "0";
        return;
    }
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * targetValue).toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// page Load unama animation  1500ms time ekk thula
window.addEventListener('DOMContentLoaded', () => {
    animateCounter("donors", maxDonors, 1500);
    animateCounter("lives", maxLives, 1500);
    animateCounter("camps", maxCamps, 1500);
});
</script>

</body>
</html>