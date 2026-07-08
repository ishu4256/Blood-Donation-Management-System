<?php
// Database එකට සම්බන්ධ වීමේ විස්තර
$servername = "localhost";
$username = "root";       // ඔබේ Database username එක
$password = "";           // ඔබේ Database password එක
$dbname = "blood_donations"; // ඔබේ Database නම

// Connection එක සාදා ගැනීම
$conn = new mysqli($servername, $username, $password, $dbname);

// සම්බන්ධතාවය පරීක්ෂා කිරීම
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Contact Message Form එක submit කර ඇති දැයි පරීක්ෂා කිරීම
if (isset($_POST['submit_message'])) {
    
    // ලැබෙන දත්ත ආරක්ෂිතව ලබා ගැනීම (SQL Injection වලින් ආරක්ෂා වීමට)
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // දත්ත ඇතුළත් කිරීමේ SQL Query එක
    $sql = "INSERT INTO contact_messages (full_name, email, subject, message) 
            VALUES ('$full_name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

// 2. Modal Form එක හරහා Blood Request එකක් ආ විට එය 'blood_bookings' table එකට ඇතුළත් කිරීම
if (isset($_POST['add_request'])) {
    $patient_name  = $conn->real_escape_string($_POST['patient_name']);
    $blood_group   = $conn->real_escape_string($_POST['blood_group']);
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $required_date = $conn->real_escape_string($_POST['date']);

    /* 💡 නිවැරදි කිරීම 1: 
       'requests' වෙනුවට 'blood_bookings' ලෙස වගු නාමය සහ 
       ඊට අදාළ තීරු නාමයන් (name, booking_date) නිවැරදි කර ඇත.
    */
    $sql_request = "INSERT INTO blood_bookings (name, blood_group, hospital_name, booking_date, status) 
                    VALUES ('$patient_name', '$blood_group', '$hospital_name', '$required_date', 'Pending')";

    if ($conn->query($sql_request) === TRUE) {
        echo "<script>alert('Blood request submitted successfully!'); window.location.href='contact.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

/* 💡 නිවැරදි කිරීම 2: 
   'requests' වෙනුවට 'blood_bookings' වගුවෙන් දත්ත කියවීමට සකස් කර ඇත.
*/
$query = "SELECT * FROM blood_bookings ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Blood Donation System</title>

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
            background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
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
        <a href="contact.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr>
    <h1 class="mt-5">Contact Blood Donation Support</h1>
    <p>We are ready to help you 24/7</p>
</div>

<div class="container py-5">
    <h2 class="text-center section-title">Get In Touch</h2>
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

<div class="container mb-5">
    <div class="contact-form">
        <h2 class="text-center text-danger mb-4">Send Us a Message</h2>
        <form action="contact.php" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Type your message" required></textarea>
            </div>
            <button type="submit" name="submit_message" class="btn btn-danger">Send Message</button>
        </form>
    </div>
</div>

<div class="container mb-5">
    <h2 class="text-center section-title">Frequently Asked Questions</h2>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">Who can donate blood?</button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show">
                <div class="accordion-body">Healthy people between 18-60 years old can donate blood.</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">How often can I donate blood?</button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse">
                <div class="accordion-body">Every 3 months for healthy donors.</div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="help-box">
        <h2 class="text-danger">Need Blood Urgently?</h2>
        <p>Contact our emergency hotline immediately for urgent blood requests.</p>
        <a href="book_blood.php" class="btn btn-danger text-white fw-bold">Blood Requests</a>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>About Us</h4>
                <p>Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently.</p>
            </div>
            <div class="col-md-4">
                <h4>Quick Links</h4>
                <a href="Services.php">Services</a>
                <a href="donor.php">Donors</a>
                <a href="evnts.php">Events & News</a>
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="col-md-4">
                <h4>Contact</h4>
                <p class="m-0">Email: sandarekaishani83@gmail.com</p>
                <p class="m-0">Phone: +94782314518</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Connection එක වසා දැමීම
$conn->close();
?>