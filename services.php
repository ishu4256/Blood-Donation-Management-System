<?php
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$search_results = null;
$searched_blood = "";
$searched_province = "";
$searched_district = "";
$modal_open_script = ""; // sewimak kala vita popup ek ehenmama thiyaganna

// Search button ek click karama wena dewal
if(isset($_POST['search_blood_submit'])){
    $searched_blood = $conn->real_escape_string($_POST['blood_group']);
    $searched_province = $conn->real_escape_string($_POST['province']);
    $searched_district = $conn->real_escape_string($_POST['district']);
    
    // Database  'Province' and 'Districrt' therima
    $query = "SELECT * FROM donor WHERE blood_group = '$searched_blood' AND Province = '$searched_province' AND Districrt = '$searched_district' AND availability_status = 'Available'";
    $search_results = $conn->query($query);
    
    // page Refresh unata passeth Popup ek ibema ari thibimatath kalin thoragaththa data ehenmama thiyaganna JavaScript ekak sakasai
    $modal_open_script = "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('blood_searchModal'));
            myModal.show();
            
            // select karapu province ekata adala district ek dropdown ekat load kirima
            const provinceSelect = document.getElementById('province');
            provinceSelect.value = '$searched_province';
            provinceSelect.dispatchEvent(new Event('change'));
            
            // kalin thoragath disrict ek sdlct wela penna
            document.getElementById('district').value = '$searched_district';
        });
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Donation Services</title>
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
            background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
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
            font-family:sans-serif, Arial;
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
        <a href="Services.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Services</a>    
        <a href="donor.php" class="btn btn-light">Donor</a>
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>

    <hr>
    <br><br><br>
    <h1>
        <a href="donor_rejiststion.php" class="btn btn-light"> Registration as a Donor</a>
    </h1>
    <br> <hr>
    <br><br><br>
    <h3><br>
            If you want to contact a Blood Donor, please click this button to search for a Blood Donor. <br><br>
        <button type="button" class="btn btn-light btn-lg fw-bold px-5 py-3 shadow" data-bs-toggle="modal" data-bs-target="#blood_searchModal">
            🩸 search blood Donor
            
        </button>
    </h3>
</div>

<div class="modal fade" id="blood_searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background: #8e0000; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold" id="searchModalLabel">🔍 Advanced Blood Availability Search</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Blood Group</label>
                            <select class="form-select" name="blood_group" required>
                                <option value="" selected disabled>Select Blood</option>
                                <option value="A+" <?php if($searched_blood == 'A+') echo 'selected'; ?>>A+</option>
                                <option value="A-" <?php if($searched_blood == 'A-') echo 'selected'; ?>>A-</option>
                                <option value="B+" <?php if($searched_blood == 'B+') echo 'selected'; ?>>B+</option>
                                <option value="B-" <?php if($searched_blood == 'B-') echo 'selected'; ?>>B-</option>
                                <option value="AB+" <?php if($searched_blood == 'AB+') echo 'selected'; ?>>AB+</option>
                                <option value="AB-" <?php if($searched_blood == 'AB-') echo 'selected'; ?>>AB-</option>
                                <option value="O+" <?php if($searched_blood == 'O+') echo 'selected'; ?>>O+</option>
                                <option value="O-" <?php if($searched_blood == 'O-') echo 'selected'; ?>>O-</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Province</label>
                            <select class="form-select" id="province" name="province" required>
                                <option value="" selected disabled>Select Province</option>
                                <option value="Western" <?php if($searched_province == 'Western') echo 'selected'; ?>>Western</option>
                                <option value="Central" <?php if($searched_province == 'Central') echo 'selected'; ?>>Central</option>
                                <option value="Southern" <?php if($searched_province == 'Southern') echo 'selected'; ?>>Southern</option>
                                <option value="Northern" <?php if($searched_province == 'Northern') echo 'selected'; ?>>Northern</option>
                                <option value="Eastern" <?php if($searched_province == 'Eastern') echo 'selected'; ?>>Eastern</option>
                                <option value="North Western" <?php if($searched_province == 'North Western') echo 'selected'; ?>>North Western</option>
                                <option value="North Central" <?php if($searched_province == 'North Central') echo 'selected'; ?>>North Central</option>
                                <option value="Uva" <?php if($searched_province == 'Uva') echo 'selected'; ?>>Uva</option>
                                <option value="Sabaragamuwa" <?php if($searched_province == 'Sabaragamuwa') echo 'selected'; ?>>Sabaragamuwa</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">District</label>
                            <select class="form-select" id="district" name="district" required>
                                <option value="" selected disabled>Select District</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="search_blood_submit" class="btn btn-danger btn-lg px-5 fw-bold shadow-sm">Check Availability</button>
                    </div>
                </form>

                <?php if($search_results !== null): ?>
                    <hr class="my-4">
                    <?php if($search_results->num_rows > 0): ?>
                        <div class="alert alert-success text-center fw-bold">
                            🩸 Available Blood Matches Found in <?php echo htmlspecialchars($searched_district); ?>!
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mt-2">
                                <thead class="table-dark" style="background: #8e0000 !important;">
                                    <tr>
                                        <th>Donor Name</th>
                                        <th>Location/Address</th>
                                        <th>Contact Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $search_results->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                                        <td>📍 <?php echo htmlspecialchars($row['address']); ?></td>
                                        <td>📞 <a href="tel:<?php echo $row['phone']; ?>" class="text-decoration-none fw-bold text-danger"><?php echo htmlspecialchars($row['phone']); ?></a></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center fw-bold">
                            ❌ Sorry, no active donors available for '<?php echo htmlspecialchars($searched_blood); ?>' in <?php echo htmlspecialchars($searched_district); ?> at the moment.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="s">
    <p>Our Services are,</p> 
</div>

<div class="t">
<pre>
<h1> Core Services </h1>
- Donor Matching: Finding donors based on the blood type needed by patients.
- Emergency Blood Request: Ability to post requests 24 hours a day in case of emergency blood needs.
- Blood Camp Organization: Providing guidance to organize blood donation camps for schools, institutions or societies.
- Inventory Alerts: Informing donors when a certain blood type is running low in blood banks.

<h1>Services for Donors</h1>
- Health Check-up History: Allows you to view the basic health check-up records performed before donating blood through the system.
- Donation Scheduling: Make an appointment to donate blood at a convenient date and time.
- Eligibility Consultation: Allows you to check whether you are eligible to donate blood through the system.

<h1>Awareness & Education</h1>
- Blood Usage Info: Provide information on which patients your donated blood will be used for (e.g. Thalassemia, Surgery, Accidents).
- Mobile Units: Provide information on locations where mobile blood units arrive.
- 24/7 Helpline: Telephone support that can be contacted in case of any problem.

<h1>Benefits for You:</h1>
- Free health check-up (Iron levels, Blood pressure).
- Increases vitality by producing new blood cells.
- Reduced risk of heart disease.
- Self-satisfaction of saving a human life.
</pre>
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
                    <img src="images/b.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Urgent Alerts</h4>
                    <p>Receive notifications for emergency blood requirements.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/c.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                    <h4>Donor Registration</h4>
                    <p>Register easily and become a life-saving donor.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <img src="images/d.jpg" alt="Easy Search Logo" class="img-fluid mb-3" style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
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
//Map Object 
const districtMap = {
    "Western": ["Colombo", "Gampaha", "Kalutara"],
    "Central": ["Kandy", "Matale", "Nuwara Eliya"],
    "Southern": ["Galle", "Matara", "Hambantota"],
    "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu"],
    "Eastern": ["Trincomalee", "Batticaloa", "Ampara"],
    "North Western": ["Kurunegala", "Puttalam"],
    "North Central": ["Anuradhapura", "Polonnaruwa"],
    "Uva": ["Badulla", "Moneragala"],
    "Sabaragamuwa": ["Ratnapura", "Kegalle"]
};

document.getElementById('province').addEventListener('change', function() {
    const selectedProvince = this.value;
    const districtSelect = document.getElementById('district');
    
    // Clear previous options
    districtSelect.innerHTML = '<option value="" selected disabled>Select District</option>';
    
    if (districtMap[selectedProvince]) {
        districtMap[selectedProvince].forEach(function(district) {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
});
</script>

<?php 
// searck karapu ekk Popup ek openwa thabime Script ek kriyathmaka kirima
if(!empty($modal_open_script)) {
    echo $modal_open_script;
}
?>

</body>
</html>