<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location: Dashboard.php");
    exit();
}

$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

// Counts
$donors = $conn->query("SELECT COUNT(*) AS total FROM donor")->fetch_assoc()['total'];
$hospitals = $conn->query("SELECT COUNT(*) AS total FROM hospitals")->fetch_assoc()['total'];
$bookings = $conn->query("SELECT COUNT(*) AS total FROM blood_bookings")->fetch_assoc()['total'];
$volunteers = $conn->query("SELECT COUNT(*) AS total FROM volunteers")->fetch_assoc()['total'];
$campaigns = $conn->query("SELECT COUNT(*) AS total FROM campaigns")->fetch_assoc()['total'];
?>

<?php if(isset($_GET['search_donors'])){ ?>
<script>
window.onload = function(){
    new bootstrap.Modal(document.getElementById('donorModal')).show();
};
</script>
<?php } ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            /* 💡 Background එක කැපිලා පේන්න Overlay එක සකස් කළා */
            background-image: linear-gradient(rgba(9, 11, 15, 0.75), rgba(30, 35, 41, 0.85)), url('images/bc.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .topbar {
            background: #8e0000;
            color: white;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .dashboard-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
            color: #8e0000;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        /* 💡 සුදු පාට බොක්ස් වල පැහැදිලි බව වැඩි දියුණු කිරීම */
        .action-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }
        
        .action-box h4, .action-box h3 {
            color: #495057;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* 💡 උඩ තියෙන සංඛ්‍යා පෙන්වන බොක්ස් වල පෙනුම */
        .card-box {
            color: white;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }
        
        .card-box:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.18);
        }

        .card-box h2 {
            font-size: 45px;
            font-weight: 800;
            margin: 0;
        }

        .card-box h5 {
            margin-top: 10px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        /* 💡 Vibrant Colors */
        .bg-red { background: #de3545; }
        .bg-blue { background: #0066cc; }
        .bg-orange { background: #f97316; }
        .bg-purple { background: #7c3aed; }
        .bg-magenta { background: #db2777; }

        /* Form styling */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #8e0000;
            box-shadow: 0 0 0 0.25rem rgba(142, 0, 0, 0.15);
        }

        /* Quick Menu Buttons */
        .action-box .btn {
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .action-box .btn:hover {
            transform: scale(1.02);
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        footer {
            background: #8e0000;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="alert alert-success alert-dismissible fade show text-center m-0 border-0 rounded-0 shadow-sm" role="alert" style="font-size: 18px; font-weight: 600;">
    🎉 Welcome, Admin <span class="text-danger fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="topbar d-flex justify-content-between align-items-center px-4">
    <h4 class="m-0 fw-bold">Blood Donation System - Admin Panel</h4>
    <div>
        <a href="dashboard.php" class="btn btn-light btn-sm fw-bold me-2 px-3">Dashboard</a>
        <a href="login.php" class="btn btn-outline-light btn-sm fw-bold px-3">Log Out</a>
    </div>
</div>

<div class="container mb-5">

    <h1 class="dashboard-title">ADMIN DASHBOARD</h1>

    <!-- 💡 Counts Row (සියල්ල එකම මට්ටමකට සකස් කරන ලදී) -->
    <div class="row g-3 mb-5">
        <div class="col-md-4 col-sm-6">
            <div class="card-box bg-red">
                <h2><?php echo $donors; ?></h2>
                <h5>Total Donors</h5>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card-box bg-blue">
                <h2><?php echo $hospitals; ?></h2>
                <h5>Total Hospitals</h5>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card-box bg-orange">
                <h2><?php echo $bookings; ?></h2>
                <h5>Blood Bookings</h5>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card-box bg-purple">
                <h2><?php echo $volunteers; ?></h2>
                <h5>Volunteers</h5>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card-box bg-magenta">
                <h2><?php echo $campaigns; ?></h2>
                <h5>Campaigns</h5>
            </div>
        </div>
    </div>

    <!-- Search Section 1 -->
    <div class="action-box mb-4">
        <h4 class="text-center">🔍 Search All Donors in District</h4>
        <form method="GET" action="search_donor.php"> 
            <div class="row g-3">
                <div class="col-md-4">
                    <select id="province1" name="province" class="form-select" required>
                        <option value="">Select Province</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                        <option value="Southern">Southern</option>
                        <option value="Northern">Northern</option>
                        <option value="Eastern">Eastern</option>
                        <option value="North Western">North Western</option>
                        <option value="North Central">North Central</option>
                        <option value="Uva">Uva</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="district1" name="district" class="form-select" required>
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="search_donors" class="btn btn-danger w-100 fw-bold" style="background:#dc3545;">Search All Donors</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Search Section 2 -->
    <div class="action-box mb-4">
        <h4 class="text-center">🩸 Search Blood in District</h4>
        <form method="GET" action="search_blood.php">
            <div class="row g-3">
                <div class="col-md-3">
                    <select id="province2" name="province" class="form-select" required>
                        <option value="">Select Province</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                        <option value="Southern">Southern</option>
                        <option value="Northern">Northern</option>
                        <option value="Eastern">Eastern</option>
                        <option value="North Western">North Western</option>
                        <option value="North Central">North Central</option>
                        <option value="Uva">Uva</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="district2" name="district" class="form-select" required>
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="blood_group" class="form-select" required>
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="search_blood" class="btn btn-danger w-100 fw-bold" style="background:#dc3545;">Search Blood</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Search Section 3 -->
    <div class="action-box mb-5">
        <h4 class="text-center">🏥 Search Blood in Hospitals</h4>
        <form method="GET" action="search_hospital_blood.php">
            <div class="row g-3">
                <div class="col-md-3">
                    <select id="province3" name="province" class="form-select" required>
                        <option value="">Select Province</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                        <option value="Southern">Southern</option>
                        <option value="Northern">Northern</option>
                        <option value="Eastern">Eastern</option>
                        <option value="North Western">North Western</option>
                        <option value="North Central">North Central</option>
                        <option value="Uva">Uva</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="district3" name="district" class="form-select" required>
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="blood_group" class="form-select" required>
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="search_hospital_blood" class="btn btn-primary w-100 fw-bold" style="background-color: #8e0000; border: none;">Search Hospital Blood</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Access Menu -->
    <div class="action-box mb-5">
        <h3 class="mb-4 text-center">⚡ Quick Access Menu</h3>
        <div class="row g-3">
            <div class="col-md-4"><a href="view_donors.php" class="btn btn-danger w-100">View Donors</a></div>
            <div class="col-md-4"><a href="view_hospitals.php" class="btn btn-primary w-100">View Hospitals</a></div>
            <div class="col-md-4"><a href="blood_stock.php" class="btn btn-success w-100">Blood Stock</a></div>
            <div class="col-md-4"><a href="messages.php" class="btn btn-info text-white w-100">Contact Messages</a></div>
            <div class="col-md-4"><a href="campaigns.php" class="btn btn-secondary w-100">Campaigns</a></div>
            <div class="col-md-4"><a href="boking.php" class="btn btn-danger w-100">Blood Bookings / Requests</a></div>
            <div class="col-md-4"><a href="volunteers.php" class="btn btn-secondary w-100">Volunteers</a></div>
            <div class="col-md-4"><a href="admin_feedback.php" class="btn btn-secondary w-100">Feedback</a></div>
            <div class="col-md-4"><a href="released_list.php" class="btn btn-warning text-dark w-100">Release Blood</a></div>
        </div>
    </div>

    <!-- PDF Reports -->
    <div class="action-box">
        <h3 class="text-center mb-4">📄 PDF Reports</h3>
        <div class="row g-3">
            <div class="col-md-4"><a href="donor_pdf.php" class="btn btn-dark w-100">Download Donor PDF</a></div>
            <div class="col-md-4"><a href="hospital_pdf.php" class="btn btn-dark w-100">Download Hospital PDF</a></div>
            <div class="col-md-4"><a href="bloodstock_pdf.php" class="btn btn-dark w-100">Download Blood Stock PDF</a></div>
        </div>
    </div>

</div>

<footer>
    Blood Donation Management System - Admin Dashboard
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const districts = {
    "Western":["Colombo","Gampaha","Kalutara"],
    "Central":["Kandy","Matale","Nuwara Eliya"],
    "Southern":["Galle","Matara","Hambantota"],
    "Northern":["Jaffna","Kilinochchi","Mannar","Mullaitivu","Vavuniya"],
    "Eastern":["Ampara","Batticaloa","Trincomalee"],
    "North Western":["Kurunegala","Puttalam"],
    "North Central":["Anuradhapura","Polonnaruwa"],
    "Uva":["Badulla","Monaragala"],
    "Sabaragamuwa":["Ratnapura","Kegalle"]
};

function loadDistricts(provinceId, districtId) {
    document.getElementById(provinceId).addEventListener("change", function(){
        let district = document.getElementById(districtId);
        district.innerHTML = '<option value="">Select District</option>';
        if(districts[this.value]) {
            districts[this.value].forEach(function(item){
                district.innerHTML += '<option value="'+item+'">'+item+'</option>';
            });
        }
    });
}

loadDistricts("province1","district1");
loadDistricts("province2","district2");
loadDistricts("province3","district3");
</script>
</body>
</html>