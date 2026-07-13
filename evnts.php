<?php
session_start();

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

// database eken beragaththa/release karapu blood count(Lives Saved) 
$db_lives = 0;
$release_res = $conn->query("SELECT SUM(units) AS total_released FROM blood_releases");
if($release_res) {
    $release_row = $release_res->fetch_assoc();
    $db_lives = $release_row['total_released'] ?? 0; 
}

// Upcoming campping details ganna
$current_date = date('Y-m-d');
$camps_res = $conn->query("SELECT * FROM campaigns WHERE campaign_date >= '$current_date' ORDER BY campaign_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events & News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
        }

        /* TOP BAR */
        .top-bar {
            background: #8e0000;
            padding: 15px 30px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(rgba(142, 0, 0, 0.85), rgba(192, 57, 43, 0.85)), url('images/pic1.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 80px 20px;
            text-align: center;
            border-bottom: 5px solid #de3545;
        }
        .hero h1 {
            font-size: 50px;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .nav-buttons .btn {
            margin: 6px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-buttons .btn:hover {
            transform: translateY(-2px);
        }

        /* SECTION STYLING */
        .section {
            padding: 60px 20px;
        }
        .section-title {
            text-align: center;
            color: #8e0000;
            font-weight: 800;
            margin-bottom: 40px;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-title::after {
            content: '';
            width: 80px;
            height: 4px;
            background: #de3545;
            display: block;
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* EVENT CARDS - MODERN LOOK */
        .event-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }
        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .event-body {
            padding: 24px;
        }
        .event-body h4 {
            color: #8e0000;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .event-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        /* URGENT ALERT BOX */
        .alert-box {
            background: linear-gradient(135deg, #fff5f5, #ffe3e3);
            border-left: 8px solid #dc3545;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.1);
        }

        /* COUNTER BOX */
        .counter-box {
            background: linear-gradient(135deg, #8e0000, #de3545);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(142, 0, 0, 0.2);
        }
        .counter-box h1 {
            font-size: 65px;
            font-weight: 800;
        }

        /* CARDS / ARTICLES */
        .article-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            border-top: 4px solid #de3545;
        }

        /* AWARDS */
        .award-card {
            background: white;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }
        .award-card img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #de3545;
        }

        /* FOOTER */
        footer {
            background: #4a0000;
            color: #f8f9fa;
            padding: 50px 20px 20px;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.2s;
        }
        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

<div class="top-bar d-flex align-items-center justify-content-between flex-wrap">
    <div class="text-start order-1">
        <a href="profile.php" class="btn btn-light btn-sm fw-bold shadow-sm px-3">👤 Profile</a>
    </div>    

    <div class="top-bara order-2 my-2">
        <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:100px; height:100px; object-fit:cover;">
    </div>

    <div class="text-end order-3">
        <a href="login.php" class="btn btn-outline-light btn-sm fw-bold shadow-sm px-3">Log Out</a>
    </div>  
</div>

<div class="hero">
    <div class="nav-buttons mb-4">
        <a href="Dashboard.php" class="btn btn-light">Dashboard</a>
        <a href="Services.php" class="btn btn-light">Services</a>
        <a href="donor.php" class="btn btn-light">Donors</a>
        <a href="evnts.php" class="btn btn-warning fw-bold text-dark border border-2 border-light shadow-sm">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr class="opacity-25 my-4">
    <h1>
        <a href="donor_rejiststion.php" class="btn btn-light btn-lg fw-bold text-danger shadow-sm">Registration as a Donor</a>
    </h1>
</div>

<!-- 📅 Upcoming Blood Donation Camps Section -->
<div class="section">
    <div class="container">
        <h1 class="section-title">Upcoming Mobile Blood Donation Camps</h1>
        <div class="row g-4">
            <?php 
            if ($camps_res && $camps_res->num_rows > 0) {
                while($camp = $camps_res->fetch_assoc()) {
                    $camp_date = date("Y F d", strtotime($camp['campaign_date']));
                    $start = date("g:i A", strtotime($camp['start_time']));
                    $end = date("g:i A", strtotime($camp['end_time']));
                    
                    // Maps ekata Search Query ekak lesa 
                    $map_query = urlencode($camp['location'] . ' ' . $camp['district']);
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="event-card">
                    <img src="images/event1.jpg" alt="<?php echo htmlspecialchars($camp['title']); ?>">
                    <div class="event-body">
                        <h4><?php echo htmlspecialchars($camp['title']); ?></h4>
                        <div class="event-info">📅  &nbsp;<b><?php echo $camp_date; ?></b></div>
                        <div class="event-info">🕒  &nbsp;<?php echo $start . " - " . $end; ?></div>
                        <div class="event-info">📍  &nbsp;<?php echo htmlspecialchars($camp['location']) . ", " . htmlspecialchars($camp['district']); ?></div>
                        <div class="event-info">🏢  &nbsp;Organized by <?php echo htmlspecialchars($camp['organizer']); ?></div>
                        
                        <?php if(!empty($camp['description'])): ?>
                            <p class="text-muted small mt-2 italic">"<?php echo htmlspecialchars($camp['description']); ?>"</p>
                        <?php endif; ?>
                        
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $map_query; ?>" target="_blank" class="btn btn-danger w-100 mt-3 fw-bold">View Direction</a>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center text-muted py-4 fs-5'>No upcoming blood donation camps scheduled at the moment.</div>";
            }
            ?>
        </div>
    </div>
</div>

<div class="section bg-light">
    <div class="container">
        <h1 class="section-title">Urgent Blood Shortage Alerts</h1>
        <div class="alert-box">
            <h3 class="text-danger fw-bold">🚨 Blood Urgently Needed</h3>
            <p class="fs-5 text-dark">Certain blood types are running extremely low in our central storage. If you are eligible, please schedule an appointment immediately.</p>
            <a href="book_blood.php" class="btn btn-danger btn-lg fw-bold px-4 mt-2">Book Now</a>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Success Stories & Impact Metrics</h1>
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Successful Blood Donation Campaign</h4>
                    <p class="mt-3 text-secondary fs-5">
                        Last week's blood donation campaign successfully collected over 50 liters of blood and helped save many lives across Sri Lanka. Thank you to all the noble donors who participated.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="counter-box">
                    <h1 id="counter">0</h1>
                    <h4 class="text-uppercase fw-bold opacity-75">Lives Saved</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section bg-light">
    <div class="container">
        <h1 class="section-title">Awareness Articles & Health Tips</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Before Donating Blood</h4>
                    <p class="text-secondary">Drink plenty of water and eat healthy meals before donating blood.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Benefits of Blood Donation</h4>
                    <p class="text-secondary">Blood donation improves blood circulation and helps maintain heart health.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="article-card">
                    <h4 class="text-danger fw-bold">Blood Groups Information</h4>
                    <p class="text-secondary">Learn about compatible blood groups and emergency donation requirements.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h1 class="section-title">Special Appreciations & Awards</h1>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event.jpg" alt="Donor">
                    <h4 class="text-danger fw-bold fs-5">Donor of the Month</h4>
                    <p class="mb-1"><strong>Kasun Perera</strong></p>
                    <p class="text-muted small mb-0">25 Successful Donations</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event1.jpg" alt="Volunteer">
                    <h4 class="text-danger fw-bold fs-5">Best Volunteer Team</h4>
                    <p class="mb-1"><strong>Colombo Youth Group</strong></p>
                    <p class="text-muted small mb-0">10 Successful Campaigns</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="award-card">
                    <img src="images/event3.jpg" alt="Community">
                    <h4 class="text-danger fw-bold fs-5">Top Organizing Community</h4>
                    <p class="mb-1"><strong>Kandy Community Society</strong></p>
                    <p class="text-muted small mb-0">500+ Blood Donations</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="text-white fw-bold mb-3">About Us</h4>
                <p class="text-white-50">Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently to save lives.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="text-white fw-bold mb-3">Quick Links</h4>
                <a href="Services.php">Services</a>
                <a href="donor.php">Donors</a>
                <a href="evnts.php">Events & News</a>
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="text-white fw-bold mb-3">Contact</h4>
                <p class="text-white-50 mb-1">Email: sandarekaishani83@gmail.com</p>
                <p class="text-white-50">Phone: +94782314518</p>
            </div>
        </div>
        <hr class="opacity-25 my-4">
        <div class="text-center text-white-50 small">
            &copy; 2026 Blood Donation Management System. All Rights Reserved.
        </div>
    </div>
</footer>

<script>
const targetValue = <?php echo $db_lives; ?>;

function animateCounter(elementId, target, duration) {
    let obj = document.getElementById(elementId);
    if (target === 0) {
        obj.innerHTML = "0";
        return;
    }
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * target).toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

window.addEventListener('DOMContentLoaded', () => {
    animateCounter("counter", targetValue, 1500);
});
</script>

</body>
</html>