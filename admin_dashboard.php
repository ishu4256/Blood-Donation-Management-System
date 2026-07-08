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

new bootstrap.Modal(
document.getElementById('donorModal')
).show();

};

</script>

<?php } ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f4f6f9;
            font-family:Arial;
        }

        .topbar{
            background:#8e0000;
            color:white;
            padding:15px;
        }

        .dashboard-title{
            text-align:center;
            margin-top:30px;
            margin-bottom:30px;
            color:#8e0000;
            font-weight:bold;
        }

        .card-box{
            color:white;
            border-radius:10px;
            padding:25px;
            text-align:center;
            box-shadow:0px 0px 10px #ccc;
        }

        .card-box h2{
            font-size:40px;
            font-weight:bold;
        }

        .card-box h5{
            margin-top:10px;
        }

        .bg-red{
            background:#dc3545;
        }

        .bg-blue{
            background:#0d6efd;
        }

        .bg-green{
            background:#198754;
        }

        .bg-orange{
            background:#fd7e14;
        }

        .bg-purple{
            background:#6f42c1;
        }

        .action-box{
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0px 0px 10px #ddd;
        }

        footer{
            background:#8e0000;
            color:white;
            text-align:center;
            padding:15px;
            margin-top:50px;
        }

    </style>

</head>

<body>

<div class="alert alert-success alert-dismissible fade show text-center m-0 border-0 rounded-0" role="alert" style="font-size: 20px; font-weight: bold;">
    🎉 Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="topbar d-flex justify-content-between">

    <h3>Blood Donation System - Admin Panel</h3>

     <a href="dashboard.php" class="btn btn-light">
        Dashboard
    </a>

   <a href="login.php" class="btn btn-light" >Log Out</a>

</div>

<div class="container">

    <h1 class="dashboard-title">
        ADMIN DASHBOARD
    </h1>

  <div class="action-box mb-4">
    <h4 class="text-center">Search All Donors in District</h4>
    
    <form method="GET" action="search_donor.php"> 
        <div class="row">
            <div class="col-md-4">
                <select id="province1" name="province" class="form-control" required>
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
                <select id="district1" name="district" class="form-control" required>
                    <option value="">Select District</option>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" name="search_donors" class="btn btn-danger w-100">
                    Search All Donors
                </button>
            </div>
        </div>
    </form>
</div>

<div class="action-box mb-4">
    <h4 class="text-center">Search Blood in District</h4>
    
    <form method="GET" action="search_blood.php">
        <div class="row">
            <div class="col-md-3">
                <select id="province2" name="province" class="form-control" required>
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
                <select id="district2" name="district" class="form-control" required>
                    <option value="">Select District</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="blood_group" class="form-control" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" name="search_blood" class="btn btn-danger w-100">
                    Search Blood
                </button>
            </div>
        </div>
    </form>
</div>

<div class="action-box mb-4">
    <h4 class="text-center">Search Blood in Hospitals</h4>
    
    <form method="GET" action="search_hospital_blood.php">
        <div class="row">
            <div class="col-md-3">
                <select id="province3" name="province" class="form-control" required>
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
                <select id="district3" name="district" class="form-control" required>
                    <option value="">Select District</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="blood_group" class="form-control" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" name="search_hospital_blood" class="btn btn-primary w-100" style="background-color: #8e0000; border: none;">
                    Search Hospital Blood
                </button>
            </div>
        </div>
    </form>
</div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card-box bg-red">
                <h2><?php echo $donors; ?></h2>
                <h5>Total Donors</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box bg-blue">
                <h2><?php echo $hospitals; ?></h2>
                <h5>Total Hospitals</h5>
            </div>
        </div>

        

        <div class="col-md-6">
            <div class="card-box bg-orange">
                <h2><?php echo $bookings; ?></h2>
                <h5>Blood Bookings or Requests</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-box bg-purple">
                <h2><?php echo $volunteers; ?></h2>
                <h5>Volunteers</h5>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box bg-purple">
                <h2><?php echo $campaigns; ?></h2>
                <h5>Campaigns</h5>
            </div>
        </div>

    </div>

    <br><br>

    <div class="action-box">

        <h3 class="mb-4 text-center">
            Quick Access Menu
        </h3>

        <div class="row g-3">

            <div class="col-md-4">
                <a href="view_donors.php"
                   class="btn btn-danger w-100">
                    View Donors
                </a>
            </div>

            <div class="col-md-4">
                <a href="view_hospitals.php"
                   class="btn btn-primary w-100">
                    View Hospitals
                </a>
            </div>

            <div class="col-md-4">
                <a href="blood_stock.php"
                   class="btn btn-success w-100">
                    Blood Stock
                </a>
            </div>

            

            <div class="col-md-4">
                <a href="messages.php"
                   class="btn btn-info w-100">
                    Contact Messages
                </a>
            </div>

            <div class="col-md-4">
                <a href="campaigns.php"
                   class="btn btn-secondary w-100">
                    Campaigns
                </a>
            </div>
            <div class="col-md-4">
                <a href="boking.php"
                   class="btn btn-danger w-100">
                    Blood Bookings or Requests
                </a>
            </div>
            <div class="col-md-4">
                <a href="volunteers.php"
                   class="btn btn-secondary w-100">
                    Volunteers
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin_feedback.php"
                   class="btn btn-secondary w-100">
                    Feedback
                </a>
            </div>

             <div class="col-md-4">
                <a href="released_list.php"
                   class="btn btn-warning w-100">
                    Release Blood
                </a>
            </div>
        </div>

    </div>

    <br>

    <div class="action-box">

        <h3 class="text-center mb-4">
            PDF Reports
        </h3>

        <div class="row g-3">

            <div class="col-md-4">
                <a href="donor_pdf.php"
                   class="btn btn-dark w-100">
                    Download Donor PDF
                </a>
            </div>

            <div class="col-md-4">
                <a href="hospital_pdf.php"
                   class="btn btn-dark w-100">
                    Download Hospital PDF
                </a>
            </div>

            <div class="col-md-4">
                <a href="bloodstock_pdf.php"
                   class="btn btn-dark w-100">
                    Download Blood Stock PDF
                </a>
            </div>

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

function loadDistricts(provinceId,districtId)
{
document.getElementById(provinceId)
.addEventListener("change",function(){

let district =
document.getElementById(districtId);

district.innerHTML =
'<option value="">Select District</option>';

if(districts[this.value])
{
districts[this.value].forEach(function(item){

district.innerHTML +=
'<option value="'+item+'">'+item+'</option>';

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