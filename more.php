<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>More Services</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}

.top-bar{
    background:#8e0000;
    padding:10px 30px;
    text-align:right;
}

.top-bara{
    text-align:center;
}

.hero{
    background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)),
    url('images/pic1.jpg');

    background-size:cover;
    color:white;
    text-align:center;
    padding:80px 20px;
}

.nav-buttons .btn{
    margin:8px;
}

.more-card{
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 10px #ccc;
    height:100%;
    text-align:center;
}

.more-card h4{
    color:#c0392b;
}

.info-box{
    background:#fdecea;
    padding:40px;
    border-radius:15px;
    text-align:center;
}

footer{
    background:#8e0000;
    color:white;
    padding:40px 20px;
    margin-top:50px;
}

</style>

</head>

<body>

<div class="top-bar">

<a href="login.php" class="btn btn-light">Log Out</a>

<div class="top-bara mt-3">

<img src="images/logo.png"
class="img-fluid rounded-circle shadow"
style="width:200px;height:200px;object-fit:cover;">

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

<a href="about.php" class="btn btn-light">About Us</a>

<a href="more.php"
class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">
More
</a>

</div>

<hr>

<h1 class="mt-5">More Blood Donation Services</h1>

<p>
Additional services and important health information
</p>

</div>

<div class="container py-5">

<div class="row g-4">

<div class="col-md-4">

<div class="more-card">

<h4>Blood Compatibility</h4>

<p>
Learn which blood groups can donate and receive safely.
</p>

<a href="#" class="btn btn-danger">
Read More
</a>

</div>

</div>

<div class="col-md-4">

<div class="more-card">

<h4>Volunteer Program</h4>

<p>
Join our volunteer community and help organize donation events.
</p>

<a href="#" class="btn btn-danger">
Join Now
</a>

</div>

</div>

<div class="col-md-4">

<div class="more-card">

<h4>Hospital Partnerships</h4>

<p>
We work with hospitals islandwide for emergency blood supply.
</p>

<a href="#" class="btn btn-danger">
View Partners
</a>

</div>

</div>

</div>

<div class="info-box mt-5">

<h2 class="text-danger">
Did You Know?
</h2>

<p>
One blood donation can save up to 3 lives.
Blood donation improves blood circulation and helps patients during emergencies.
</p>

</div>

<div class="row mt-5 g-4">

<div class="col-md-6">

<div class="more-card">

<h4>Useful Links</h4>

<a href="https://health.gov.lk" target="_blank" class="btn btn-outline-danger m-2">
Ministry of Health
</a>

<a href="https://nbts.health.gov.lk" target="_blank" class="btn btn-outline-danger m-2">
National Blood Transfusion Service
</a>

</div>

</div>

<div class="col-md-6">

<div class="more-card">

<h4>Emergency Contacts</h4>

<p>🚑 National Blood Centre - 011 533 6666</p>

<p>🚑 Emergency Hotline - 1990</p>

<p>🚑 Suwa Seriya Ambulance Service</p>

</div>

</div>

</div>

</div>

<footer>

<div class="container">

<div class="row">

<div class="col-md-4">

<h4>About Us</h4>

<p>
Online Blood Donation System Sri Lanka helps connect donors and recipients.
</p>

</div>

<div class="col-md-4">

<h4>Quick Links</h4>

<a href="Services.php" class="text-white d-block">Services</a>

<a href="donor.php" class="text-white d-block">Donors</a>

<a href="evnts.php" class="text-white d-block">Events</a>

</div>

<div class="col-md-4">

<h4>Contact Us</h4>

<p>Email: support@blooddonation.lk</p>

<p>Phone: +94 77 123 4567</p>

</div>

</div>

</div>

</footer>

</body>
</html>