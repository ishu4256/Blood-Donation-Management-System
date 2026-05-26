<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us - Blood Donation System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            margin:0;
            padding:0;
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
            background-position:center;
            color:white;
            padding:80px 20px;
            text-align:center;
        }

        .nav-buttons .btn{
            margin:8px;
            font-weight:bold;
        }

        .section-title{
            color:#8e0000;
            font-weight:bold;
            margin-bottom:30px;
        }

        .contact-card{
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 0 10px #ccc;
            height:100%;
        }

        .contact-card h4{
            color:#c0392b;
            margin-bottom:20px;
        }

        .contact-form{
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 0 10px #ccc;
        }

        .help-box{
            background:#fdecea;
            padding:25px;
            border-radius:15px;
            text-align:center;
        }

        footer{
            background:#8e0000;
            color:white;
            padding:40px 20px;
            margin-top:50px;
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

    <div class="top-bara mt-3">

        <img src="images/logo.png"
        class="img-fluid rounded-circle shadow"
        style="width:200px;height:200px;object-fit:cover;">

    </div>

</div>

<!-- Hero -->

<div class="hero">

    <div class="nav-buttons">

        <a href="Dashboard.php" class="btn btn-light">Dashboard</a>

        <a href="Services.php" class="btn btn-light">Services</a>

        <a href="donor.php" class="btn btn-light">Donors</a>

        <a href="evnts.php" class="btn btn-light">Events & News</a>

        <a href="publication.php" class="btn btn-light">Publications</a>

        <a href="contact.php"
        class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">
        Contact Us
        </a>

        <a href="about.php" class="btn btn-light">About Us</a>

        <a href="more.php" class="btn btn-light">More</a>

    </div>

    <hr>

    <h1 class="mt-5">Contact Blood Donation Support</h1>

    <p>
        We are ready to help you 24/7
    </p>

</div>

<!-- Contact Section -->

<div class="container py-5">

    <h2 class="text-center section-title">
        Get In Touch
    </h2>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="contact-card">

                <h4>Head Office</h4>

                <p>📍 National Blood Centre, Colombo 08</p>

                <p>📞 +94 11 533 6666</p>

                <p>📧 support@blooddonation.lk</p>

                <p>🕒 Open 24 Hours</p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="contact-card">

                <h4>Emergency Hotline</h4>

                <p>🚑 Emergency Blood Requests</p>

                <p>📞 +94 77 123 4567</p>

                <p>📞 +94 71 888 9999</p>

                <p>📧 emergency@blooddonation.lk</p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="contact-card">

                <h4>Social Media</h4>

                <p>🌐 Facebook: Blood Donation SL</p>

                <p>📸 Instagram: @blooddonationsl</p>

                <p>▶ YouTube: Donate Blood Sri Lanka</p>

                <p>💬 WhatsApp Support Available</p>

            </div>

        </div>

    </div>

</div>

<!-- Contact Form -->

<div class="container mb-5">

    <div class="contact-form">

        <h2 class="text-center text-danger mb-4">
            Send Us a Message
        </h2>

        <form>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Full Name
                    </label>

                    <input type="text" class="form-control" placeholder="Enter your name">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email Address
                    </label>

                    <input type="email" class="form-control" placeholder="Enter your email">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Subject
                </label>

                <input type="text" class="form-control" placeholder="Enter subject">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Message
                </label>

                <textarea class="form-control" rows="5" placeholder="Type your message"></textarea>

            </div>

            <button class="btn btn-danger">
                Send Message
            </button>

        </form>

    </div>

</div>

<!-- FAQ -->

<div class="container mb-5">

    <h2 class="text-center section-title">
        Frequently Asked Questions
    </h2>

    <div class="accordion" id="faqAccordion">

        <div class="accordion-item">

            <h2 class="accordion-header">

                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">

                    Who can donate blood?

                </button>

            </h2>

            <div id="faq1" class="accordion-collapse collapse show">

                <div class="accordion-body">

                    Healthy people between 18-60 years old can donate blood.

                </div>

            </div>

        </div>

        <div class="accordion-item">

            <h2 class="accordion-header">

                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">

                    How often can I donate blood?

                </button>

            </h2>

            <div id="faq2" class="accordion-collapse collapse">

                <div class="accordion-body">

                    Every 3 months for healthy donors.

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Emergency Help -->

<div class="container mb-5">

    <div class="help-box">

        <h2 class="text-danger">
            Need Blood Urgently?
        </h2>

        <p>
            Contact our emergency hotline immediately for urgent blood requests.
        </p>

        <a href="#" class="btn btn-danger">
            Request Blood Now
        </a>

    </div>

</div>

<!-- Footer -->

<footer>

    <div class="container">

        <div class="row">

            <div class="col-md-4">

                <h4>About Us</h4>

                <p>
                    Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently.
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

                <h4>Contact Info</h4>

                <p>Email: support@blooddonation.lk</p>

                <p>Phone: +94 77 123 4567</p>

                <p>Location: Colombo, Sri Lanka</p>

            </div>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>