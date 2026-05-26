<!DOCTYPE html>
<html>
<head>

    <title>Events & News</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            font-family:Arial, sans-serif;
            background:#f4f6f9;
        }

        /* TOP BAR */

        .top-bar{
            background:#8e0000;
            padding:10px 30px;
            text-align:right;
        }

        .top-bara{
            text-align:center;
        }

        /* HERO */

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

        .nav-buttons .btn{
            margin:8px;
            font-weight:bold;
        }

        /* SECTION */

        .section{
            padding:60px 20px;
        }

        .section-title{
            text-align:center;
            color:#c0392b;
            font-weight:bold;
            margin-bottom:50px;
        }

        /* CARDS */

        .event-card{
            background:white;
            border-radius:20px;
            overflow:hidden;
            transition:0.3s;
            height:100%;
            box-shadow:0 0 10px #ddd;
        }

        .event-card:hover{
            transform:translateY(-8px);
        }

        .event-card img{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .event-body{
            padding:25px;
        }

        .event-body h4{
            color:#c0392b;
            font-weight:bold;
        }

        /* ALERT */

        .alert-box{
            background:#fff3f3;
            border-left:8px solid red;
            padding:25px;
            border-radius:15px;
            box-shadow:0 0 10px #ddd;
        }

        /* COUNTER */

        .counter-box{
            background:#c0392b;
            color:white;
            padding:40px;
            border-radius:20px;
            text-align:center;
        }

        .counter-box h1{
            font-size:60px;
            font-weight:bold;
        }

        /* ARTICLE */

        .article-card{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px #ddd;
            height:100%;
        }

        /* AWARDS */

        .award-card{
            background:white;
            border-radius:20px;
            padding:30px;
            text-align:center;
            box-shadow:0 0 10px #ddd;
        }

        .award-card img{
            width:100px;
            height:100px;
            border-radius:50%;
            object-fit:cover;
            margin-bottom:15px;
        }

        /* FOOTER */

        footer{
            background:#8e0000;
            color:white;
            padding:40px 20px;
        }

        footer a{
            color:white;
            text-decoration:none;
            display:block;
            margin-bottom:10px;
        }

    </style>

</head>

<body>

<!-- Top Bar -->
<div class="top-bar">
    <a href="login.php" class="btn btn-light">Log Out</a>

    <div class="top-bara">
    <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:200px; height:200px; object-fit:cover; border-radius:50%;">
</div>
</div>

<!-- Hero Section -->
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
<br><br><br><h1>
     <a href="donor_rejiststion.php" class="btn btn-light"> Registation as a Donor</a>
</h1>
   
</div>

<!-- UPCOMING EVENTS -->

<div class="section">

    <div class="container">

        <h1 class="section-title">
            Upcoming Mobile Blood Donation Camps
        </h1>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="event-card">

                    <img src="images/event1.jpg">

                    <div class="event-body">

                        <h4>Colombo Blood Camp</h4>

                        <p>📅 2026 May 15</p>

                        <p>🕒 9.00 AM - 4.00 PM</p>

                        <p>📍 Colombo Town Hall</p>

                        <p>🏢 Organized by National Blood Bank</p>

                        <a href="https://maps.google.com"
                        target="_blank"
                        class="btn btn-danger w-100 mb-2">

                        View Direction

                        </a>

                        <button class="btn btn-dark w-100">

                            Add to Calendar

                        </button>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="event-card">

                    <img src="images/event2.jpg">

                    <div class="event-body">

                        <h4>Kandy Donation Drive</h4>

                        <p>📅 2026 May 22</p>

                        <p>🕒 8.00 AM - 3.00 PM</p>

                        <p>📍 Kandy Hospital Ground</p>

                        <p>🏢 Organized by Red Cross</p>

                        <a href="https://maps.google.com"
                        target="_blank"
                        class="btn btn-danger w-100 mb-2">

                        View Direction

                        </a>

                        <button class="btn btn-dark w-100">

                            Add to Calendar

                        </button>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="event-card">

                    <img src="images/event3.jpg">

                    <div class="event-body">

                        <h4>Galle Youth Event</h4>

                        <p>📅 2026 June 05</p>

                        <p>🕒 9.00 AM - 2.00 PM</p>

                        <p>📍 Galle City Hall</p>

                        <p>🏢 Organized by Youth Society</p>

                        <a href="https://maps.google.com"
                        target="_blank"
                        class="btn btn-danger w-100 mb-2">

                        View Direction

                        </a>

                        <button class="btn btn-dark w-100">

                            Add to Calendar

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- URGENT ALERT -->

<div class="section">

    <div class="container">

        <h1 class="section-title">
            Urgent Blood Shortage Alerts
        </h1>

        <div class="alert-box">

            <h3 class="text-danger fw-bold">
                🚨 O Positive (O+) Blood Urgently Needed
            </h3>

            <p class="mt-3">

                Colombo National Hospital currently faces a critical shortage
                of O+ blood.

            </p>

            <a href="appointment.php"
            class="btn btn-danger">

            Book Now

            </a>

        </div>

    </div>

</div>

<!-- SUCCESS STORIES -->

<div class="section">

    <div class="container">

        <h1 class="section-title">
            Success Stories & Impact Metrics
        </h1>

        <div class="row g-4">

            <div class="col-md-6">

                <div class="article-card">

                    <h4 class="text-danger">

                        Successful Blood Donation Campaign

                    </h4>

                    <p class="mt-3">

                        Last week's blood donation campaign successfully
                        collected over 50 liters of blood and helped save
                        more than 120 lives across Sri Lanka.

                    </p>

                </div>

            </div>

            <div class="col-md-6">

                <div class="counter-box">

                    <h1 id="counter">
                        1500
                    </h1>

                    <h4>
                        Lives Saved
                    </h4>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- HEALTH TIPS -->

<div class="section">

    <div class="container">

        <h1 class="section-title">
            Awareness Articles & Health Tips
        </h1>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="article-card">

                    <h4 class="text-danger">
                        Before Donating Blood
                    </h4>

                    <p>

                        Drink plenty of water and eat healthy meals before donating blood.

                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="article-card">

                    <h4 class="text-danger">
                        Benefits of Blood Donation
                    </h4>

                    <p>

                        Blood donation improves blood circulation and helps maintain heart health.

                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="article-card">

                    <h4 class="text-danger">
                        Blood Groups Information
                    </h4>

                    <p>

                        Learn about compatible blood groups and emergency donation requirements.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- AWARDS -->

<div class="section">

    <div class="container">

        <h1 class="section-title">
            Special Appreciations & Awards
        </h1>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="award-card">

                    <img src="images/user1.jpg">

                    <h4 class="text-danger">
                        Donor of the Month
                    </h4>

                    <p>
                        Kasun Perera
                    </p>

                    <p>
                        25 Successful Donations
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="award-card">

                    <img src="images/user2.jpg">

                    <h4 class="text-danger">
                        Best Volunteer Team
                    </h4>

                    <p>
                        Colombo Youth Group
                    </p>

                    <p>
                        10 Successful Campaigns
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="award-card">

                    <img src="images/user3.jpg">

                    <h4 class="text-danger">
                        Top Organizing Community
                    </h4>

                    <p>
                        Kandy Community Society
                    </p>

                    <p>
                        500+ Blood Donations
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->

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

<!-- COUNTER SCRIPT -->

<script>

let count = 0;

let target = 1500;

let speed = 1;

let counter = document.getElementById("counter");

let updateCounter = setInterval(function(){

    count += 5;

    counter.innerHTML = count;

    if(count >= target){

        clearInterval(updateCounter);

    }

}, speed);

</script>

</body>
</html>