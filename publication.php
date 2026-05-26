<!DOCTYPE html>

<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Publications - Blood Donation System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    font-family:Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:0;
}

/* Top Bar */

.top-bar{
    background:#8e0000;
    padding:10px 30px;
    text-align:right;
}

.top-bara{
    text-align:center;
}

/* Hero Section */

.hero{
    background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)),
    url('images/pic1.jpg');

    background-size:cover;
    background-position:center;
    color:white;
    padding:80px 20px;
    text-align:center;
}

.hero h1{
    font-size:55px;
    font-weight:bold;
}

.hero p{
    font-size:22px;
}

/* Navigation */

.nav-buttons .btn{
    margin:8px;
    font-weight:bold;
}

/* Sections */

.section-title{
    color:#8e0000;
    font-weight:bold;
    margin-bottom:30px;
}

/* Cards */

.pub-card{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 0 10px #ddd;
    height:100%;
    transition:0.3s;
}

.pub-card:hover{
    transform:translateY(-5px);
}

.pub-card img{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:10px;
}

.pub-card h4{
    margin-top:15px;
    color:#c0392b;
}

/* Counter */

.counter-section{
    background:#fdecea;
    padding:60px 20px;
    text-align:center;
}

.counter-box{
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 10px #ddd;
}

.counter-box h1{
    font-size:60px;
    color:#c0392b;
    font-weight:bold;
}

/* Awareness */

.awareness-box{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 0 10px #ddd;
    margin-bottom:20px;
}

/* Footer */

footer{
    background:#8e0000;
    color:white;
    padding:40px 20px;
}

footer h4{
    margin-bottom:20px;
}

footer a{
    color:white;
    text-decoration:none;
    display:block;
    margin-bottom:10px;
}

footer a:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<!-- Top Bar -->

<div class="top-bar">

<a href="login.php" class="btn btn-light">
Log Out
</a>

<div class="top-bara">

<img src="images/logo.png"
alt="Blood Donation"
class="img-fluid rounded shadow"
style="width:200px;
height:200px;
object-fit:cover;
border-radius:50%;">

</div>

</div>

<!-- Hero Section -->

<div class="hero">

<div class="nav-buttons">

<a href="Dashboard.php" class="btn btn-light">Dashboard</a>

<a href="Services.php" class="btn btn-light">Services</a>

<a href="donor.php" class="btn btn-light">Donors</a>

<a href="evnts.php" class="btn btn-light">Events & News</a>

<a href="publication.php"
class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">

Publications

</a>

<a href="contact.php" class="btn btn-light">Contact Us</a>

<a href="about.php" class="btn btn-light">About Us</a>

<a href="more.php" class="btn btn-light">More</a>

</div>

<hr>

<br><br>



<a href="donor_rejiststion.php" class="btn btn-light btn-lg">

Register as a Donor

</a>

</div><br><center>
<h1>Blood Donation Publications</h1>

<p>
Awareness Articles, Research Reports & Success Stories
</p>
</center>
<br>
<!-- Publications -->

<div class="container mt-5 mb-5">

<h2 class="text-center section-title">
Latest Publications
</h2>

<div class="row g-4">

<!-- Card 1 -->

<div class="col-md-4">

<div class="pub-card">

<img src="images/pub1.jpg">

<h4>
Benefits of Blood Donation
</h4>

<p>
Regular blood donation improves blood circulation and helps save lives.
Learn about the health benefits of donating blood regularly.
</p>

<a href="#" class="btn btn-danger">
Read More
</a>

</div>

</div>

<!-- Card 2 -->

<div class="col-md-4">

<div class="pub-card">

<img src="images/pub2.jpg">

<h4>
Blood Donation Awareness Guide
</h4>

<p>
Important information about who can donate blood, preparation tips,
and post-donation care instructions.
</p>

<a href="#" class="btn btn-danger">
Read More
</a>

</div>

</div>

<!-- Card 3 -->

<div class="col-md-4">

<div class="pub-card">

<img src="images/pub3.jpg">

<h4>
Emergency Blood Campaign Report
</h4>

<p>
Summary of emergency blood donation campaigns conducted across
Sri Lanka during the last month.
</p>

<a href="#" class="btn btn-danger">
Read More
</a>

</div>

</div>

</div>

</div>

<!-- Success Counter -->

<div class="counter-section">

<div class="container">

<h2 class="section-title">
Impact Statistics
</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="counter-box">

<h1 id="donors">0</h1>

<h4>Registered Donors</h4>

</div>

</div>

<div class="col-md-4">

<div class="counter-box">

<h1 id="lives">0</h1>

<h4>Lives Saved</h4>

</div>

</div>

<div class="col-md-4">

<div class="counter-box">

<h1 id="camps">0</h1>

<h4>Blood Camps Organized</h4>

</div>

</div>

</div>

</div>

</div>

<!-- Awareness Articles -->

<div class="container mt-5 mb-5">

<h2 class="text-center section-title">
Health Tips & Awareness Articles
</h2>

<div class="row">

<div class="col-md-6">

<div class="awareness-box">

<h4 class="text-danger">
Before Donating Blood
</h4>

<ul>
<li>Drink plenty of water.</li>
<li>Eat healthy food before donation.</li>
<li>Get enough sleep the night before.</li>
<li>Avoid smoking and alcohol.</li>
</ul>

</div>

</div>

<div class="col-md-6">

<div class="awareness-box">

<h4 class="text-danger">
After Donating Blood
</h4>

<ul>
<li>Take rest for 10-15 minutes.</li>
<li>Drink fruit juice or water.</li>
<li>Avoid heavy exercise for one day.</li>
<li>Eat iron-rich foods.</li>
</ul>

</div>

</div>

</div>

</div>

<!-- Donor Appreciation -->

<div class="container mb-5">

<h2 class="text-center section-title">
Special Appreciations & Awards
</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="pub-card text-center">

<img src="images/donor1.jpg">

<h4>
Donor of the Month
</h4>

<p>
Mr. Kasun Perera donated blood 15 times this year and helped save many lives.
</p>

</div>

</div>

<div class="col-md-4">

<div class="pub-card text-center">

<img src="images/community.jpg">

<h4>
Top Organizing Community
</h4>

<p>
Kandy Youth Association successfully organized 10 blood donation camps.
</p>

</div>

</div>

<div class="col-md-4">

<div class="pub-card text-center">

<img src="images/team.jpg">

<h4>
Volunteer Appreciation
</h4>

<p>
Special thanks to all volunteers supporting our national blood donation campaigns.
</p>

</div>

</div>

</div>

</div>

<!-- Download Publications -->

<div class="container mb-5">

<h2 class="text-center section-title">
Download Publications
</h2>

<div class="row g-4">

<div class="col-md-3">

<div class="pub-card text-center">

<h4>Annual Report 2025</h4>

<p>Blood donation annual statistics report.</p>

<a href="#" class="btn btn-danger">
Download PDF
</a>

</div>

</div>

<div class="col-md-3">

<div class="pub-card text-center">

<h4>Health Guide</h4>

<p>Guide for healthy blood donation habits.</p>

<a href="#" class="btn btn-danger">
Download PDF
</a>

</div>

</div>

<div class="col-md-3">

<div class="pub-card text-center">

<h4>Research Paper</h4>

<p>Research about blood donation awareness.</p>

<a href="#" class="btn btn-danger">
Download PDF
</a>

</div>

</div>

<div class="col-md-3">

<div class="pub-card text-center">

<h4>Campaign Magazine</h4>

<p>Monthly publication of blood donation events.</p>

<a href="#" class="btn btn-danger">
Download PDF
</a>

</div>

</div>

</div>

</div>

<!-- Footer -->

<footer>

<div class="container">

<div class="row">

<div class="col-md-4">

<h4>About Us</h4>

<p>
Online Blood Donation System Sri Lanka helps connect blood donors
and recipients efficiently to save lives.
</p>

</div>

<div class="col-md-4">

<h4>Quick Links</h4>

<a href="Services.php">Services</a>

<a href="donor.php">Donors</a>

<a href="evnts.php">Events & News</a>

<a href="contact.php">Contact Us</a>

</div>

<div class="col-md-4">

<h4>Contact Us</h4>

<p>Email: support@blooddonation.lk</p>

<p>Phone: +94 77 123 4567</p>

<p>Location: Colombo, Sri Lanka</p>

</div>

</div>

</div>

</footer>

<!-- Counter Script -->

<script>

let donorCount = 0;
let livesCount = 0;
let campCount = 0;

let donorInterval = setInterval(function(){

    donorCount++;
    document.getElementById("donors").innerHTML = donorCount;

    if(donorCount == 2500){
        clearInterval(donorInterval);
    }

},1);

let livesInterval = setInterval(function(){

    livesCount++;
    document.getElementById("lives").innerHTML = livesCount;

    if(livesCount == 1800){
        clearInterval(livesInterval);
    }

},1);

let campInterval = setInterval(function(){

    campCount++;
    document.getElementById("camps").innerHTML = campCount;

    if(campCount == 120){
        clearInterval(campInterval);
    }

},20);

</script>

</body>
</html>