<?php
session_start();

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

// 🔍 District Filter කිරීමේ කේතය
$selected_district = "";
$donors_result = null;
$search_query = "";

if (isset($_POST['search_district']) && !empty($_POST['district'])) {
    $selected_district = $conn->real_escape_string($_POST['district']);
    
    // 💡 ඡායාරූපයට අනුව ටේබල් එක 'donor' විය යුතු අතර column එක 'Districrt' විය යුතුය
    $search_query = "SELECT * FROM donor WHERE Districrt LIKE '%$selected_district%'";
    $donors_result = $conn->query($search_query);
} else {
    // කිසිවක් Search කර නැත්නම් සියලුම දෙනා පෙන්වීමට
    $search_query = "SELECT * FROM donor LIMIT 10";
    $donors_result = $conn->query($search_query);
}

// Map එක සඳහා Default ලිපිනය (දිස්ත්‍රික්කය අනුව Google Map එක වෙනස් වීමට)
$map_address = "Sri Lanka";
if (!empty($selected_district)) {
    $map_address = $selected_district . " Blood Bank, Sri Lanka";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blood Donation Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body{ font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
        .top-bar{ background:#8e0000; padding:10px 30px; text-align:right; }
        .top-bara{ text-align:center; }
        .hero{
            background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
            background-size:cover; background-position:center; color:white; padding:80px 20px; text-align:center;
        }
        .hero h1{ font-size:60px; font-weight:bold; }
        .nav-buttons .btn{ margin:8px; font-weight:bold; }
        .t{ font-size:20px; background: white; padding: 40px 20px; border-radius: 15px; box-shadow: 0 0 10px #ddd; }
        .main-section{ padding:50px 20px; }
        .features{ background:white; padding:50px 20px; }
        .feature-card{ text-align:center; padding:25px; background:#fff; border-radius:10px; box-shadow:0 0 10px #ddd; height:100%; }
        .info-section{ padding:50px; background:#fdecea; text-align:center; }
        .mv-section{ padding:50px 20px; background:white; }
        .mv-card{ padding:30px; border-radius:10px; box-shadow:0 0 10px #ddd; height:100%; }
        .mv-card h3{ color:#c0392b; }
        footer{ background:#8e0000; color:white; padding:40px 20px; }
        footer a{ color:white; text-decoration:none; display:block; margin-bottom:10px; }
        footer a:hover{ text-decoration:underline; }
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
    height:790px;
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
    background:rgba(108, 78, 78, 0.45);
    z-index:2;
}
        /* New Custom Layout Styles */
        .search-box { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .map-container { border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .donor-badge { background: #c0392b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 13px; }
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
        <a href="donor.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Donor</a>  
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>
    <hr>
    <br><br><br>
    <h1>
        <a href="donor_rejiststion.php" class="btn btn-light btn-lg fw-bold text-danger shadow-sm">Registration as a Donor</a>
    </h1>
</div>
<div class="dashboard-video-container">

    <video class="bg-video" autoplay muted loop playsinline>
        <source src="images/bg-video.mp4.mp4" type="video/mp4">
    </video>

   
</div>
<div class="text-center my-4">
    <a href="book_blood.php" class="btn btn-danger btn-lg fw-bold shadow px-4">Blood Requests</a>
</div>

<div class="container mt-5 mb-5">
    <h1 class="text-center text-danger fw-bold mb-2"><i class="fas fa-map-marked-alt"></i> Find Registered Donors & Blood Banks</h1>
    <p class="text-center text-muted mb-5">ඔබේ දිස්ත්‍රික්කය තෝරා එම ප්‍රදේශයේ සිටින ලියාපදිංචි දායකයින් සහ ලේ බැංකු පහසුවෙන් සොයාගන්න.</p>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="search-box mb-4">
                <h4 class="text-danger fw-bold mb-3"><i class="fas fa-search"></i> Search by District</h4>
                
                <form action="" method="POST" class="row g-2">
                    <div class="col-8">
                        <select name="district" class="form-select form-control-lg" required>
                            <option value="">-- Select District --</option>
                            <?php
                            $districts = ["Colombo", "Gampaha", "Kalutara", "Kandy", "Matale", "Nuwara Eliya", "Galle", "Matara", "Hambantota", "Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu", "Batticaloa", "Ampara", "Trincomalee", "Kurunegala", "Puttalam", "Anuradhapura", "Polonnaruwa", "Badulla", "Moneragala", "Ratnapura", "Kegalle"];
                            foreach($districts as $dist) {
                                $selected = (strtolower($selected_district) == strtolower($dist)) ? "selected" : "";
                                echo "<option value='$dist' $selected>$dist</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <button type="submit" name="search_district" class="btn btn-danger w-100 fw-bold"><i class="fas fa-search"></i> Find</button>
                    </div>
                </form>
            </div>

            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                    <span>👥 Registered Donors <?php echo (!empty($selected_district)) ? "in " . htmlspecialchars($selected_district) : "(Recent)"; ?></span>
                    <span class="badge bg-danger"><?php echo $donors_result ? $donors_result->num_rows : 0; ?> Found</span>
                </div>
                <div class="card-body p-0" style="max-height: 380px; overflow-y: auto;">
                    <?php if ($donors_result && $donors_result->num_rows > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php while($row = $donors_result->fetch_assoc()): ?>
                                <div class="list-group-item p-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-user-circle text-secondary me-1"></i> <?php echo htmlspecialchars($row['full_name']); ?></h6>
                                        <span class="donor-badge font-monospace fw-bold"><?php echo htmlspecialchars($row['blood_group']); ?></span>
                                    </div>
                                    <p class="mb-1 small text-muted"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo htmlspecialchars($row['Districrt']); ?> | <?php echo htmlspecialchars($row['Province']); ?></p>
                                    <small class="text-primary fw-bold"><i class="fas fa-phone-alt me-1"></i> <?php echo htmlspecialchars($row['phone']); ?></small>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-users-slash fa-2x mb-2"></i>
                            <p class="mb-0">මෙම දිස්ත්‍රික්කයෙන් දායකයින් කිසිවෙකු තවමත් ලියාපදිංචි වී නොමැත.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="map-container h-100">
                <iframe 
                    src="https://maps.google.com/maps?q=<?php echo urlencode($map_address); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                    width="100%" 
                    height="510" 
                    style="border:0; min-height: 450px;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="t">
        <h1 class="text-danger fw-bold text-center mb-4">FOR DONORS <hr class="w-25 mx-auto"></h1>
        
        <h3 class="text-center fw-bold mb-3 text-secondary">Basic Donor Eligibility Criteria</h3>
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 fs-5">
                <p class="mb-2">✔ Age between 18 – 60 years</p>
                <p class="mb-2">✔ Weight should be above 50kg</p>
                <p class="mb-2">✔ Must be physically healthy</p>
                <p class="mb-2">✔ No serious diseases</p>
                <p class="mb-2">✔ Minimum 3 months gap after previous donation</p>
                <p class="mb-2">✔ Should not be pregnant</p>
                <p class="mb-2">✔ Hemoglobin level should be normal</p>
            </div>
        </div>

        <h3 class="text-center fw-bold mb-3 text-secondary">Before Donating Blood</h3>
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 fs-5">
                <p class="mb-2">✔ Have a main meal within 4 hours.</p>
                <p class="mb-2">✔ Drink plenty of fluids.</p>
                <p class="mb-2">✔ Avoid alcohol.</p>
                <p class="mb-2">✔ Rest at least 6 hours the previous night.</p>
            </div>
        </div>

        <h3 class="text-center fw-bold mb-3 text-secondary">After Donating Blood</h3>
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 fs-5">
                <p class="mb-2">✔ Rest for at least 20 minutes.</p>
                <p class="mb-2">✔ Drink more fluids in the next 4 hours.</p>
                <p class="mb-2">✔ Keep plaster on for about 12 hours.</p>
                <p class="mb-2">✔ Avoid heavy lifting for 24 hours.</p>
            </div>
        </div>
    </div>
</div>

<div class="features">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Key Features</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/a.jpg" alt="Easy Search" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Easy Search</h4>
                    <p>Find nearby blood donors and donation camps quickly.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/b.jpg" alt="Urgent Alerts" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Urgent Alerts</h4>
                    <p>Receive notifications for emergency blood requirements.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/c.jpg" alt="Registration" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Donor Registration</h4>
                    <p>Register easily and become a life-saving donor.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/d.jpg" alt="Community" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Community Support</h4>
                    <p>Join a strong network dedicated to saving lives.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="info-section">
    <h2>Blood Donation Finder - Sri Lanka</h2>
    <p class="fs-5 max-width-700 mx-auto">
        Our platform connects blood donors with patients in urgent need across Sri Lanka.
        By creating awareness, organizing campaigns, and connecting communities,
        we aim to ensure that no life is lost due to blood shortages.
    </p>
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
                <p>Email: sandarekaishani83@gmail.com</p>
                <p>Phone: +94782314518</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>