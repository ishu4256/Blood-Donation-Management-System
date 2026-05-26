<!DOCTYPE html>
<html >
<head>
    
    <title>Blood Donation Dashboard</title>

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

        /* Navigation */
        .nav-buttons .btn{
            margin:8px;
            font-weight:bold;
        }
.t{
    font-size:25px;

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

        <a href="Services.php" class="btn btn-light">Services</a>
<a href="donor.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Donor</a>  
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


<div class="t"><pre>
       <h1> Who can Donate Blood </h1>
       <pre>
                                ✔ Age between 18 – 60 years

                                ✔ Weight should be above 50kg

                                ✔ Must be physically healthy

                                ✔ No serious diseases

                                ✔ Minimum 3 months gap after previous donation

                                ✔ Should not be pregnant

                                ✔ Hemoglobin level should be normal</pre>
        
       <h1> Mobile Blood Donation Schedule</h1><pre>
                                        <ul>
                                                        <li>📅 May 15, 2026 - Colombo National Blood Camp</li>
                                                        <li>📅 May 22, 2026 - Kandy Community Donation Drive</li>
                                                        <li>📅 June 05, 2026 - Galle Youth Blood Donation Event</li>
                                                        <li>📅 June 12, 2026 - Jaffna Emergency Blood Campaign</li>
                                                    </ul>
</pre>
         
<!-- Blood Bank Map Section -->

<div class="container mt-5 mb-5">

    <h1 class="text-center text-danger mb-4">
        Blood Bank Map
    </h1>

   
<center>
        <!-- Google Map -->
<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d31687.81337442066!2d79.85337239406!3d6.893393608756128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sblood%20bank%20sri%20lanka!5e0!3m2!1sen!2slk!4v1779728513812!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</center>

    <!-- Blood Bank List -->
<h2 class="text-danger">
                        National Blood Centers in Sri Lanka
                    </h2>


                </div>

            </div>

        </div>
                    <center>


         <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        colombo Blood Bank
                    </h5>

                    <p>
                        📍 Colombo 08, Sri Lanka
                    </p>

                    <p>
                        📞 011 533 6666
                    </p>
                    <p>
                        🕒 Open 24 Hours
                    </p>

                    <a href="https://maps.google.com/?q=National+Blood+Centre+Colombo"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>
        <br><br><br>
<div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        Jaffna Blood Bank
                    </h5>
                    <p>
                        📍 Jaffna, Sri Lanka
                    </p>

                    <p>
                        📞 021 222 2261
                    </p>

                    <p>
                        🕒 Open 24 Hours
                    </p>

                    <a href="https://maps.google.com/?q=Jaffna+Teaching+Hospital"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>
        <br><br><br>

        <!-- Card 5 -->

       <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        Badulla Blood Bank
                    </h5>
                    <p>
                        📍 Badulla, Sri Lanka
                    </p>

                    <p>
                        📞 055 222 2261
                    </p>

                    <p>
                        🕒 Open 24 Hours
                    </p>

                    <a href="https://maps.google.com/?q=Badulla+General+Hospital"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>
        <br><br><br>

        <!-- Card 6 -->

       <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        Kurunegala Blood Bank
                    </h5>
                    <p>
                        📍 Kurunegala, Sri Lanka
                    </p>

                    <p>
                        📞 037 222 2261
                    </p>

                    <p>
                        🕒 Open 24 Hours
                    </p>

                    <a href="https://maps.google.com/?q=Kurunegala+Hospital+Blood+Bank"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>


        <br><br><br>



        <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        Kandy Blood Bank
                    </h5>

                    <p>
                        Kandy, Sri Lanka
                    </p>

                    <p>
                        📞 081 222 2261
                    </p>

                    <a href="https://maps.google.com/?q=Teaching+Hospital+Kandy"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>

                <br><br><br>

        <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h5 class="text-danger">
                        Karapitiya Blood Bank
                    </h5>

                    <p>
                        Galle, Sri Lanka
                    </p>

                    <p>
                        📞 091 223 2561
                    </p>

                    <a href="https://maps.google.com/?q=Karapitiya+Hospital+Blood+Bank"
                    target="_blank"
                    class="btn btn-danger w-100">

                        View Location

                    </a>

                </div>

            </div>

        </div>

    </div>


</center>


        <br><br><br>






   </div>
</pre>
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