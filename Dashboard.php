<?php
// Session එක ආරම්භ කර පරිශීලකයා ලොග් වී ඇත්දැයි පරීක්ෂා කිරීම
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // ලොග් වී නොමැති නම් නැවත ලොගින් පිටුවට යවයි
    exit();
}

// ඩේටාබේස් සම්බන්ධතාවය (Database Connection)
$conn = new mysqli("localhost", "root", "", "blood_donations");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default SQL Query (සියලුම සක්‍රීය campaigns පෙන්වීමට)
$campaign_sql = "SELECT title, campaign_date, location FROM campaigns WHERE status = 'Active' OR status = 'Upcoming' ORDER BY campaign_date ASC";

// පරිශීලකයා දිනයක් තෝරා Search කර ඇත්නම් SQL Query එක වෙනස් කිරීම
$selected_date = "";
if (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
    $selected_date = $conn->real_escape_string($_GET['search_date']);
    // තෝරාගත් දිනයට අදාළ දත්ත පමණක් ලබා ගැනීම
    $campaign_sql = "SELECT title, campaign_date, location FROM campaigns WHERE campaign_date = '$selected_date' ORDER BY campaign_date ASC";
}

$campaign_result = $conn->query($campaign_sql);
?>

<?php
// Database එකෙන් රෝහල් ලැයිස්තුව ලබා ගැනීම
$location_string = "";
// රෝහලේ නම, ලිපිනය (location) සහ දිස්ත්‍රික්කය ලබා ගැනීම
$hospitals_query = "SELECT name, location, district FROM hospitals";
$hospitals_result = $conn->query($hospitals_query);

if ($hospitals_result && $hospitals_result->num_rows > 0) {
    $locations_array = [];
    while($h_row = $hospitals_result->fetch_assoc()) {
        // රෝහලේ නම සහ ලිපිනය එකතු කිරීම (e.g., "Teaching Hospital - Karapitiya, Karapitiya, Galle")
        $locations_array[] = $h_row['name'] . ", " . $h_row['location'];
    }
    // සියලුම රෝහල්වල නම් සහ ලිපින ' OR ' මඟින් වෙන් කර එකම සෙවුම් පදයක් (Query) ලෙස සිතියමට ලබා දීම
    $location_string = urlencode(implode(" OR ", $locations_array));
} else {
    // ඩේටාබේස් එකේ රෝහල් නැත්නම් Default ලෙස ලංකාවේ ලේ බැංකු පෙන්වයි
    $location_string = urlencode("Blood Bank Hospital Sri Lanka");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blood Donation Dashboard</title>

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
            /* සෙවීම් කළ විට මේ කොටසටම focus වීමට අවකාශය සලසයි */
            scroll-margin-top: 20px; 
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
        
        .map-section-anchor {
            scroll-margin-top: 30px;
        }

        .dashboard-video-container {
    position: relative;
    width: 100%;
    height: 300px; /* ඔයාට අවශ්‍ය ගාණට වෙනස් කරන්න */
    overflow: hidden;
    border-radius: 10px;
}/* පැරණි .bg-video CSS එක වෙනුවට මෙය දාන්න */
.dashboard-video-container{
    position:relative;
    width:100%;
    height:800px;
    overflow:hidden;
}

.bg-video{
    position:absolute;
    top:10;
    left:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:1;
}

.dashboard-video-container::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    z-index:2;
}

.dashboard-content{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    z-index:3;
    color:#fff;
    text-align:center;
    width:100%;
}

.dashboard-content h2{
    font-size:50px;
    font-weight:bold;
}

.dashboard-content p{
    font-size:22px;
}

.dashboard-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    color: white;
    text-align: center;
    width: 100%;
}


    </style>
</head>
<body>

<?php 
// Welcome Message එක ලොගින් වූ පළමු වතාවේ පමණක් පෙන්වීම
if (!isset($_SESSION['welcome_shown'])) { 
    $_SESSION['welcome_shown'] = true; // පෙන්වූ බව සලකුණු කරයි
?>
    <div class="alert alert-success alert-dismissible fade show text-center m-0 border-0 rounded-0" role="alert" style="font-size: 20px; font-weight: bold;">
        🎉 Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

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
        <a href="Dashboard.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Dashboard</a>
        <a href="Services.php" class="btn btn-light">Services</a>
        <a href="donor.php" class="btn btn-light">Donors</a>
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>

    <hr>

    <h1>Welcome To <br> Blood Donation Management System <br> Sri Lanka</h1>
    <p>Save Lives - Donate Blood</p>
    <br><br><br>
    <h1>
         <a href="donor_rejiststion.php" class="btn btn-light"> Registration as a Donor</a>
    </h1>

</div>

<div class="dashboard-video-container">

    <video class="bg-video" autoplay muted loop playsinline>
        <source src="images/d.mp4.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="dashboard-content">
        <h2>Every Drop Counts</h2>
        <p>Join Our Hands To Save More Lives</p>

       
    </div>

</div>
<div class="container main-section">
    <div class="row">

        <div class="col-md-7">
            <div class="caption">Save Lives - Donate Blood
                <br><br>
                <img src="images/image1.jpg" alt="Blood Donation" class="img-fluid rounded shadow">
            </div>
            <div><br><br></div>
        </div>

        <div class="col-md-5" id="campaign-section">
            <div class="news-box">
                <h3>Latest News & Donation Campaigns</h3>
                
                <form method="GET" action="Dashboard.php#campaign-section" class="mb-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-7">
                            <input type="date" name="search_date" class="form-control" value="<?php echo isset($_GET['search_date']) ? htmlspecialchars($_GET['search_date']) : ''; ?>">
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-danger w-100 fw-bold" style="background-color: #c0392b; border: none; height: 38px;">Search</button>
                        </div>
                    </div>
                    <?php if (!empty($selected_date)): ?>
                        <div class="text-start mt-2">
                            <a href="Dashboard.php#campaign-section" class="text-decoration-none text-muted small">❌ Clear Filter</a>
                        </div>
                    <?php endif; ?>
                </form>

                <ul class="list-unstyled">
                    <?php 
                    if ($campaign_result->num_rows > 0) {
                        while($row = $campaign_result->fetch_assoc()) {
                            $formatted_date = date("F d, Y", strtotime($row['campaign_date']));
                            echo "<li class='border-bottom pb-2 mb-2'>📅 <b>" . $formatted_date . "</b><br> " . htmlspecialchars($row['title']) . " <br><small class='text-muted'>📍 " . htmlspecialchars($row['location']) . "</small></li>";
                        }
                    } else {
                        if (!empty($selected_date)) {
                            echo "<li class='text-danger fw-bold'>📅 No donation campaigns found on this date.</li>";
                        } else {
                            echo "<li>📅 No upcoming donation campaigns found.</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

    </div>

    <div class="text-center mt-4">
        <h4>
        A blood donation system dashboard helps blood banks manage donors, requests, and stock from one place, making the whole process faster and more organized. It gives real-time updates on blood availability, reduces manual errors, and supports better reporting and campaign planning. This improves efficiency and helps ensure blood is available when it is needed most.
        </h4>
        <br><br><br>

        <h1>What it usually includes</h1>
        <br><br>
        <ul class="list-unstyled fs-5 d-inline-block text-start">
            <li>- Donor registration and profile management.</li>
            <li>- Blood request posting and donor search by blood group or location.</li>
            <li>- Donation event or camp management.</li>
            <li>- SMS, email, or app alerts for urgent needs.</li>
            <li>- Blood inventory and history tracking for blood banks.</li>
        </ul>
        <br><br><br><br>

        <h1>Common benefits</h1>
        <br><br>
        <ul class="list-unstyled fs-5 d-inline-block text-start">
            <li>- Faster matching between patients and available donors.</li>
            <li>- Better communication between blood banks and the public.</li>
            <li>- Improved tracking of donor history and blood stock.</li>
            <li>- Easier promotion of donation camps and recruitment drives.</li>
        </ul>
    </div>
</div>

<div id="map-view-section" class="map-section-anchor"></div>
<center>
    <h2 class="text-center mb-3" style="color: #c0392b; font-weight: bold;">Find Nearest Blood Bank</h2>
    <div style="width: 80%; max-width: 500px; margin-bottom: 20px;">
        <button type="button" class="btn btn-danger w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#locationModal" style="background-color: #8e0000; border: none; height: 45px; font-size: 18px;">
            📍 Find Blood Banks Near Me
        </button>
    </div>

    <h2 class="text-center mb-3" style="color: #c0392b; font-weight: bold;">Find Blood Banks & Hospitals in Sri Lanka</h2>
    <div class="map-container" style="width: 80%; max-width: 900px; border: 3px solid #8e0000; border-radius: 10px; overflow: hidden; box-shadow: 0 0 15px gray;">
        <iframe 
            id="blood-bank-map"
            src="https://maps.google.com/maps?q=<?php echo $location_string; ?>&t=&z=10&ie=UTF8&iwloc=&output=embed" 
            width="100%" 
            height="500" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</center>
<br><br>

<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8e0000; color: white;">
        <h5 class="modal-title" id="locationModalLabel">📍 Enter Your Location</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="popupLocationForm" onsubmit="searchNearestBanks(event)">
            <div class="mb-3">
                <label for="user-location-input" class="form-label fw-bold">Your Current Town / City or Address:</label>
                <input type="text" id="user-location-input" class="form-control" placeholder="e.g., Colombo, Kandy, Galle" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger fw-bold px-4" style="background-color: #c0392b; border: none;">Search Blood Banks</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="features">
    <div class="container">
        <h2 class="text-center mb-5">Key Features</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/a.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Easy Search</h4>
                    <p>Find nearby blood donors and donation camps quickly.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/b.jpg" alt="Urgent Alerts Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Urgent Alerts</h4>
                    <p>Receive notifications for emergency blood requirements.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/c.jpg" alt="Donor Registration Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Donor Registration</h4>
                    <p>Register easily and become a life-saving donor.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/d.jpg" alt="Community Support Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Community Support</h4>
                    <p>Join a strong network dedicated to saving lives.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="info-section">
    <h2>Blood Donation Finder - Sri Lanka</h2>
    <p>
        Our platform connects blood donors with patients in urgent need across Sri Lanka.
        By creating awareness, organizing campaigns, and connecting communities,
        we aim to ensure that no life is lost due to blood shortages.
    </p>
</div>

<div class="mv-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Vision</h3>
                    <p>To create a healthier Sri Lanka where safe blood is available for everyone, anytime, anywhere.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Mission</h3>
                    <p>To build a reliable blood donation network through technology, awareness, and compassionate community support.</p>
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
                <p>Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently to save lives.</p>
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
               <p>Email: sandarekaishani83@gmail.com</p>
               <p>Phone: +94782314518</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function searchNearestBanks(event) {
    event.preventDefault(); // Form එක submit වෙලා page එක refresh වීම වලක්වයි
    
    // User type කරපු ලොකේෂන් එක ලබා ගැනීම
    var userLocation = document.getElementById('user-location-input').value;
    
    if (userLocation.trim() !== "") {
        // සිතියමේ URL එක සකස් කිරීම (User ඉන්න තැන + Blood Bank & Hospitals)
        var searchQuery = encodeURIComponent(userLocation + " Blood Bank Hospital");
        var mapUrl = "https://maps.google.com/maps?q=" + searchQuery + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
        
        // Iframe එක නව සිතියමට මාරු කිරීම
        document.getElementById('blood-bank-map').src = mapUrl;
        
        // Popup එක වසා දැමීම (Bootstrap Modal Close)
        var myModalEl = document.getElementById('locationModal');
        var modal = bootstrap.Modal.getInstance(myModalEl);
        modal.hide();
        
        // සිතියම තියෙන තැනට පිටුව Scroll කිරීම (No Top Scroll)
        document.getElementById('map-view-section').scrollIntoView({ behavior: 'smooth' });
    }
}
</script>

</body>
</html>