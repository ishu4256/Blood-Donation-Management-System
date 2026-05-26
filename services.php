<!DOCTYPE html>
<html >
<head>
    
    <title>Blood Donation Services</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body{
            font-family: Arial, sans-serif;
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
            font-size:60px;
            font-weight:bold;
        }

        .hero p{
            font-size:25px;
        }

.s{
            font-size:75px;
                        font-family:sans-serifial;

        }
.t{
    font-size:25px;

}
        /* Navigation */
        .nav-buttons .btn{
            margin:8px;
            font-weight:bold;
        }

        /* Main Section */
        .main-section{
            padding:50px 20px;
        }

        .image-box img{
            width:100%;
            border-radius:10px;
            box-shadow:0 0 10px gray;
        }

       

        /* News Box */
        .news-box{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px gray;
        }

        .news-box h3{
            color:#c0392b;
            margin-bottom:20px;
        }

        .news-box ul li{
            margin-bottom:15px;
            font-size:18px;
        }

        /* Features */
        .features{
            background:white;
            padding:50px 20px;
        }

        .feature-card{
            text-align:center;
            padding:25px;
            background:#fff;
            border-radius:10px;
            box-shadow:0 0 10px #ddd;
            height:100%;
        }

        .feature-card i{
            font-size:40px;
            color:#c0392b;
            margin-bottom:15px;
        }

        /* Paragraph Section */
        .info-section{
            padding:50px;
            background:#fdecea;
            text-align:center;
        }

        /* Mission Vision */
        .mv-section{
            padding:50px 20px;
            background:white;
        }

        .mv-card{
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px #ddd;
            height:100%;
        }

        .mv-card h3{
            color:#c0392b;
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
    <a href="login.php" class="btn btn-light">Log Out</a>

    <div class="top-bara">
    <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:200px; height:200px; object-fit:cover; border-radius:50%;">
</div>
</div>

<!-- Hero Section -->
<div class="hero">

    <div class="nav-buttons">
                        <a href="Dashboard.php" class="btn btn-light">Dashboard</a>

<!-- Services button highlighted -->
<a href="Services.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Services</a>    
           <a href="donor.php" class="btn btn-light">Donor</a>

<a href="evnts.php" class="btn btn-light">Events & News</a>
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
<div class="s">
    <p>
        Our Services are, 
</div>
<div class="t"><pre>
       <h1> Core Services </h1>
        - Donor Matching: Finding donors based on the blood type needed by patients.

        - Emergency Blood Request: Ability to post requests 24 hours a day in case of emergency blood needs.

        - Blood Camp Organization: Providing guidance to organize blood donation camps for schools, institutions or societies.

        - Inventory Alerts: Informing donors when a certain blood type is running low in blood banks.




<h1>
Services for Donors</h1>
        - Health Check-up History: Allows you to view the basic health check-up records performed before donating blood through the system.

        - Donation Scheduling: Make an appointment to donate blood at a convenient date and time.

        - Eligibility Consultation: Allows you to check whether you are eligible to donate blood through the system.





<h1>
Awareness & Education</h1>
        - Blood Usage Info: Provide information on which patients your donated blood will be used for (e.g. Thalassemia, Surgery, Accidents).

        - Mobile Units: Provide information on locations where mobile blood units arrive.

        - 24/7 Helpline: Telephone support that can be contacted in case of any problem.




        <h1>
Benefits for You:
</h1>
        - Free health check-up (Iron levels, Blood pressure).

        - Increases vitality by producing new blood cells.

        - Reduced risk of heart disease.

        - Self-satisfaction of saving a human life.

</pre>
</p>
</div>


   

<!-- Key Features -->
<div class="features">
    <div class="container">
        <h2 class="text-center mb-5">Key Features</h2>

        <div class="row g-4">

            <div class="col-md-3">
    <div class="feature-card">

        <!-- Easy Search Logo -->
        <img src="images/a.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">

        <h4>Easy Search</h4>
        <p>Find nearby blood donors and donation camps quickly.</p>

    </div>
</div>

            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fas fa-bell"></i>
                            <img src="images/b.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">

                    <h4>Urgent Alerts</h4>
                    <p>Receive notifications for emergency blood requirements.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fas fa-user-plus"></i>
                            <img src="images/c.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">

                    <h4>Donor Registration</h4>
                    <p>Register easily and become a life-saving donor.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                            <img src="images/d.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">

                    <h4>Community Support</h4>
                    <p>Join a strong network dedicated to saving lives.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Paragraph -->
<div class="info-section">
    <h2>Blood Donation Finder - Sri Lanka</h2>
    <p>
        Our platform connects blood donors with patients in urgent need across Sri Lanka.
        By creating awareness, organizing campaigns, and connecting communities,
        we aim to ensure that no life is lost due to blood shortages.
    </p>
</div>

<!-- Mission & Vision -->
<div class="mv-section">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Vision</h3>
                    <p>
                        To create a healthier Sri Lanka where safe blood is available
                        for everyone, anytime, anywhere.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Mission</h3>
                    <p>
                        To build a reliable blood donation network through technology,
                        awareness, and compassionate community support.
                    </p>
                </div>
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

</body>
</html>