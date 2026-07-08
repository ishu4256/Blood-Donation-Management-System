<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

// 🔍 FILTER LOGIC
$filter_status = "";
$where_clause = "";

if (isset($_GET['status_filter']) && $_GET['status_filter'] !== "") {
    $filter_status = $conn->real_escape_string($_GET['status_filter']);
    $where_clause = " WHERE availability_status = '$filter_status'";
}

// Query එක සකස් කිරීම
$sql = "SELECT * FROM donor" . $where_clause . " ORDER BY donor_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background:#f4f6f9;
            font-family:Arial, sans-serif;
        }
        .container-box{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px #ccc;
            margin-top:30px;
        }
        .table th { 
            background-color: #dc3545 !important; 
            color: white !important; 
            text-align: center;
            white-space: nowrap; /* Column නම් කැඩී පහළට යාම වැළැක්වීමට */
        }
        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }
        td {
            white-space: nowrap; /* දත්ත තනි පේළියට ලස්සනට තබා ගැනීමට */
        }
        .text-wrap-custom {
            white-space: normal !important; /* ලිපිනය වැනි දිගු දත්ත අවශ්‍ය පරිදි කැඩී පෙනීමට */
            min-width: 200px;
        }
    </style>
</head>
<body>

<div class="container-fluid px-5 mb-5"> <div class="container-box">

        <h2 class="text-center text-danger mb-4">
            Registered Donors Comprehensive List
        </h2>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="admin_dashboard.php" class="btn btn-secondary">
                    ← Back to Dashboard
                </a>
            </div>
            
            <form method="GET" action="" class="d-flex gap-2">
                <select name="status_filter" class="form-select border-danger" style="min-width: 200px;">
                    <option value="">-- All Availability Status --</option>
                    <option value="Available" <?php if($filter_status == 'Available') echo 'selected'; ?>>Available Only</option>
                    <option value="Not Available" <?php if($filter_status == 'Not Available') echo 'selected'; ?>>Not Available Only</option>
                </select>
                <button type="submit" class="btn btn-danger fw-bold">Filter</button>
                <?php if($filter_status !== "") { ?>
                    <a href="view_donors.php" class="btn btn-outline-secondary">Reset</a>
                <?php } ?>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle small"> <thead>
                    <tr class="table-danger">
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Weight</th>
                        <th>Blood Group</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>Address</th>
                        <th>Last Donation</th>
                        <th>Diseases</th>
                        <th>Medicines</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            
                            $status = $row['availability_status'];
                            $badge_class = (strcasecmp($status, 'Available') == 0) ? 'bg-success' : 'bg-danger';
                            
                            // Profile photo එකක් නොතිබුනහොත් Default පින්තූරයක් පෙන්වීමට
                            $photo_path = !empty($row['profile_photo']) ? "uploads/profile/" . $row['profile_photo'] : "uploads/profile/default.png";
                            
                            // හිස් අගයන් (NULL) තිබේ නම් ඒවා වෙනුවට "N/A" ලෙස පෙන්වීමට
                            $dob = !empty($row['dob']) && $row['dob'] != '0000-00-00' ? $row['dob'] : 'N/A';
                            $gender = !empty($row['gender']) ? $row['gender'] : 'N/A';
                            $weight = !empty($row['weight']) && $row['weight'] > 0 ? $row['weight'] . " kg" : 'N/A';
                            $last_donation = !empty($row['last_donation_date']) && $row['last_donation_date'] != '0000-00-00' ? $row['last_donation_date'] : 'None / New';
                            $diseases = !empty($row['diseases']) ? $row['diseases'] : 'None';
                            $medicines = !empty($row['medicines']) ? $row['medicines'] : 'None';
                            $address = !empty($row['address']) ? $row['address'] : 'N/A';
                            $province = !empty($row['Province']) ? ucwords($row['Province']) : 'N/A';
                            $district = !empty($row['Districrt']) ? ucwords($row['Districrt']) : 'N/A'; // Database එකේ අක්ෂර වින්‍යාසය (Districrt) අනුව නිවැරදි කර ඇත
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $row['donor_id']; ?></td>
                        <td class="text-center">
                            <img src="<?php echo $photo_path; ?>" class="profile-img" alt="Donor">
                        </td>
                        <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['nic']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($dob); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($gender); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($weight); ?></td>
                        <td class="text-center"><span class="badge bg-dark fs-6"><?php echo htmlspecialchars($row['blood_group']); ?></span></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($province); ?></td>
                        <td><?php echo htmlspecialchars($district); ?></td>
                        <td class="text-wrap-custom"><?php echo htmlspecialchars($address); ?></td>
                        <td class="text-center fw-bold text-secondary"><?php echo htmlspecialchars($last_donation); ?></td>
                        <td class="text-wrap-custom text-danger"><?php echo htmlspecialchars($diseases); ?></td>
                        <td class="text-wrap-custom text-warning text-dark"><?php echo htmlspecialchars($medicines); ?></td>
                        <td class="text-center">
                            <span class="badge <?php echo $badge_class; ?> px-3 py-2 text-uppercase" style="font-size: 11px;">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="edit_donor.php?id=<?php echo $row['donor_id']; ?>" class="btn btn-warning btn-sm fw-bold">
                                    Edit
                                </a>
                                <a href="delete_donor.php?id=<?php echo $row['donor_id']; ?>" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Delete this donor?')">
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='18' class='text-center text-muted py-4'>❌ No Donors found for the selected filter criteria.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="add_donor.php" class="btn btn-success fw-bold">
                ➕ Add New Donor
            </a>
        </div>

    </div>

</div>

</body>
</html>