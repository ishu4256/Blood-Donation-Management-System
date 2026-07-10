<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
require 'vendor/autoload.php';
session_start();

// Admin කෙනෙක්දැයි පරීක්ෂා කිරීම (Security)
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

// 🔔 5. USER CAMPAIGN APPROVAL + EMAIL NOTIFICATION
if(isset($_GET['approve_id'])){

    $approve_id = intval($_GET['approve_id']);

    // Campaign details ගන්න
    $campaign_result = $conn->query("
        SELECT *
        FROM campaigns
        WHERE id = $approve_id
        LIMIT 1
    ");

    if($campaign_result && $campaign_result->num_rows > 0){

        $campaign = $campaign_result->fetch_assoc();

        $title         = $campaign['title'];
        $organizer     = $campaign['organizer'];
        $location      = $campaign['location'];
        $district      = $campaign['district'];
        $campaign_date = $campaign['campaign_date'];
        $start_time    = $campaign['start_time'];
        $end_time      = $campaign['end_time'];
        $description   = $campaign['description'];

        // Campaign approve කරන්න
        $approve_query = "
            UPDATE campaigns
            SET status='Upcoming'
            WHERE id=$approve_id
            AND status='Pending'
        ";

        if($conn->query($approve_query)){

            // Same district donors පමණක් ලැබීමට අවශ්‍ය නම් WHERE district = '$district' ලෙස වෙනස් කරන්න.
            $donors = $conn->query("
                SELECT full_name, email
                FROM donor
                WHERE email IS NOT NULL
                AND email != ''
            ");

            if($donors && $donors->num_rows > 0){

                while($donor = $donors->fetch_assoc()){

                    try{

                        $mail = new PHPMailer(true);
                        $mail->SMTPDebug = 0;
                        $mail->Debugoutput = 'html';
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;

                        $mail->Username = 'sandarekaishani83@gmail.com';
                        $mail->Password = 'zmnr dbgs jxhv kqqk';

                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom(
                            'sandarekaishani83@gmail.com',
                            'Blood Donation Management System'
                        );

                        $mail->addAddress($donor['email']);

                        $name = $donor['full_name'];

                        $mail->isHTML(true);

                        $mail->Subject = 'New Blood Donation Campaign - '.$district;

                        $mail->Body = "
                        <h2>Dear $name,</h2>
                        <p>A new blood donation campaign has been approved in your district.</p>
                        <table border='1' cellpadding='8' cellspacing='0'>
                            <tr><td><b>Campaign</b></td><td>$title</td></tr>
                            <tr><td><b>Organizer</b></td><td>$organizer</td></tr>
                            <tr><td><b>Location</b></td><td>$location</td></tr>
                            <tr><td><b>District</b></td><td>$district</td></tr>
                            <tr><td><b>Date</b></td><td>$campaign_date</td></tr>
                            <tr><td><b>Time</b></td><td>$start_time - $end_time</td></tr>
                            <tr><td><b>Description</b></td><td>$description</td></tr>
                        </table>
                        <br>
                        <p>Please participate and help save lives through blood donation.</p>
                        <p>Thank you,<br>Blood Donation Management System</p>
                        ";

                        $mail->send();

                    } catch (Exception $e) {
                        echo "Email Error : " . $mail->ErrorInfo;
                        exit();
                    }
                }
            }

            echo "<script>
                alert('Campaign approved and email notifications sent successfully!');
                window.location.href='campaigns.php';
            </script>";
            exit();
        }
    }
}

// ➕ 1. ADMIN DIRECTLY ADD BLOOD STOCK LOGIC (මැනුවලී එකතු කිරීම)
if(isset($_POST['add_direct_stock'])){
    $district = $conn->real_escape_string($_POST['direct_district']);
    $hospital_name = $conn->real_escape_string($_POST['direct_hospital']); 
    $blood_group = strtoupper($conn->real_escape_string($_POST['direct_blood_group'])); // Capitalize Group
    $units = intval($_POST['direct_units']);
    $collected_date = $conn->real_escape_string($_POST['direct_collected_date']); 

    // එකම දවසේ, එකම රෝහලේ, එකම ලේ වර්ගය තිබේදැයි බැලීම
    $stock_res = $conn->query("SELECT id FROM blood_stock WHERE district = '$district' AND name = '$hospital_name' AND blood_group = '$blood_group' AND collected_date = '$collected_date' LIMIT 1");

    if($stock_res && $stock_res->num_rows > 0){
        // තිබේ නම් -> Units අගය UPDATE වේ
        $stock_row = $stock_res->fetch_assoc();
        $stock_id = $stock_row['id'];
        $update_query = "UPDATE blood_stock SET units = units + $units WHERE id = $stock_id";
        
        if($conn->query($update_query)){
            echo "<script>alert('🎉 Blood stock updated successfully for $hospital_name!'); window.location.href='blood_stock.php';</script>";
            exit();
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    } else {
        // නැත්නම් -> අලුතින්ම INSERT වේ (District එකද සමඟ)
        $insert_query = "INSERT INTO blood_stock (name, district, blood_group, units, collected_date) VALUES ('$hospital_name', '$district', '$blood_group', $units, '$collected_date')";
        
        if($conn->query($insert_query)){
            echo "<script>alert('🎉 New blood stock manually added successfully!'); window.location.href='blood_stock.php';</script>";
            exit();
        } else {
            echo "Error inserting stock: " . $conn->error;
        }
    }
}

// 📝 2. CAMPAIGN UPDATE (EDIT) LOGIC
if(isset($_POST['update_campaign'])){
    $campaign_id = intval($_POST['campaign_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $organizer = $conn->real_escape_string($_POST['organizer']);
    $location = $conn->real_escape_string($_POST['location']);
    $district = $conn->real_escape_string($_POST['district']);
    $campaign_date = $conn->real_escape_string($_POST['campaign_date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $description = $conn->real_escape_string($_POST['description']);

    $update_sql = "UPDATE campaigns SET 
                    title='$title', 
                    organizer='$organizer', 
                    location='$location', 
                    district='$district', 
                    campaign_date='$campaign_date', 
                    start_time='$start_time', 
                    end_time='$end_time', 
                    description='$description' 
                   WHERE id=$campaign_id";

    if($conn->query($update_sql)){
        echo "<script>alert('🎉 Campaign details updated successfully!'); window.location.href='campaigns.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ Error updating campaign details.');</script>";
    }
}

// 🔄 3. CAMPAIGN COMPLETION & REGIONAL STOCK UPDATE LOGIC
if(isset($_POST['complete_campaign'])){
    $campaign_id = intval($_POST['campaign_id']);
    $blood_group = strtoupper($conn->real_escape_string($_POST['blood_group']));
    $units = intval($_POST['units']);
    $collected_date = $conn->real_escape_string($_POST['collected_date']); 

    // කැම්පේන් එකේ දිස්ත්‍රික්කය ලබා ගැනීම
    $camp_res = $conn->query("SELECT district FROM campaigns WHERE id = $campaign_id AND (status != 'Completed' OR status IS NULL)");
    
    if($camp_res && $camp_res->num_rows > 0){
        $camp_row = $camp_res->fetch_assoc();
        $district = !empty($camp_row['district']) ? $conn->real_escape_string($camp_row['district']) : 'General';
        $hospital_name = $district . " General Hospital";

        $conn->begin_transaction();
        try {
            $conn->query("UPDATE campaigns SET status = 'Completed' WHERE id = $campaign_id");
            
            $stock_res = $conn->query("SELECT id FROM blood_stock WHERE district = '$district' AND blood_group = '$blood_group' AND name = '$hospital_name' AND collected_date = '$collected_date' LIMIT 1");

            if($stock_res && $stock_res->num_rows > 0){
                $conn->query("UPDATE blood_stock SET units = units + $units WHERE district = '$district' AND blood_group = '$blood_group' AND name = '$hospital_name' AND collected_date = '$collected_date'");
            } else {
                $conn->query("INSERT INTO blood_stock (name, district, blood_group, units, collected_date) VALUES ('$hospital_name', '$district', '$blood_group', $units, '$collected_date')");
            }

            $conn->commit();
            echo "<script>alert('🎉 Campaign marked as Completed! Stock added successfully.'); window.location.href='blood_stock.php';</script>";
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Error occurred while updating stock.');</script>";
        }
    }
}

// 🗑️ 4. CAMPAIGN DELETE LOGIC
if(isset($_GET['delete_id'])){
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM campaigns WHERE id = $delete_id";
    if($conn->query($delete_query)){
        header("Location: campaigns.php");
        exit();
    }
}

// දිස්ත්‍රික්ක සහ කැම්පේන් දත්ත ලබා ගැනීම
$districts_list = $conn->query("SELECT DISTINCT district FROM hospitals ORDER BY district ASC");
$result = $conn->query("SELECT * FROM campaigns ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manage Campaigns - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#31080c; font-family: Arial, sans-serif; }
        .topbar { background: #8e0000; color: white; padding: 15px; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 20px; }
        h2, h4 { color: #8e0000; font-weight: bold; }
        .table th { background-color: #8e0000 !important; color: white !important; }
        .badge-upcoming { background-color: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .badge-completed { background-color: #198754; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .badge-pending { background-color: #0d6efd; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        footer { background: #8e0000; color: white; text-align: center; padding: 15px; margin-top: 50px; }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Admin Panel</h3>
    <div>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm me-2">Admin Dashboard</a>
        <a href="blood_stock.php" class="btn btn-warning btn-sm me-2 fw-bold">🩸 View Blood Stock</a>
        <a href="login.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
</div>

<div class="container mb-5">
    
    <div class="container-box border-start border-danger border-4">
        <h4>🩸 Add / Update Blood Stock Directly (මැනුවලී ලේ තොග එකතු කිරීම)</h4>
        <p class="text-muted small">දිස්ත්‍රික්කය සහ රෝහල තෝරා, ලේ එකතු කළ දිනය (Collected Date) ද නිවැරදිව ඇතුළත් කරන්න.</p>
        
        <form method="POST" action="">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-bold small">1. Select District</label>
                    <select name="direct_district" id="direct_district" class="form-select form-select-sm" onchange="fetchHospitals(this.value)" required>
                        <option value="">-- Select --</option>
                        <?php 
                        if($districts_list && $districts_list->num_rows > 0){
                            while($d_row = $districts_list->fetch_assoc()){
                                echo "<option value='".htmlspecialchars($d_row['district'])."'>".htmlspecialchars(ucwords($d_row['district']))."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">2. Select Hospital</label>
                    <select name="direct_hospital" id="direct_hospital" class="form-select form-select-sm" required>
                        <option value="">-- Select District First --</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">Blood Group</label>
                    <select name="direct_blood_group" class="form-select form-select-sm" required>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">Units (බෑග් ගණන)</label>
                    <input type="number" name="direct_units" class="form-control form-control-sm text-start" min="1" placeholder="Ex: 20" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">Collected Date (දින)</label>
                    <input type="date" name="direct_collected_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" name="add_direct_stock" class="btn btn-danger btn-sm fw-bold">
                        ➕ Add To Stock
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-box">
        <h2 class="text-center mb-4">🛠️ Campaign Management (Admin)</h2>
        
        <div class="d-flex justify-content-between mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
            <a href="add_campaign.php" class="btn btn-success">+ Add New Campaign</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Campaign Title</th>
                        <th>Organizer</th>
                        <th>Location & District</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 240px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $current_status = (!empty($row['status'])) ? $row['status'] : 'Upcoming';
                            
                            if($current_status == 'Completed') {
                                $status_badge = 'badge-completed';
                            } elseif($current_status == 'Pending') {
                                $status_badge = 'badge-pending';
                            } else {
                                $status_badge = 'badge-upcoming';
                            }
                            
                            $district_name = (!empty($row['district'])) ? htmlspecialchars($row['district']) : "Not Set";
                            $clean_start_time = substr($row['start_time'], 0, 8);
                            $clean_end_time = substr($row['end_time'], 0, 8);
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['organizer']); ?></td>
                        <td>
                            📍 <?php echo htmlspecialchars($row['location']); ?><br>
                            <span class="badge bg-secondary btn-sm mt-1"><?php echo $district_name; ?></span>
                        </td>
                        <td class="text-nowrap">📅 <?php echo htmlspecialchars($row['campaign_date']); ?></td>
                        <td class="text-nowrap">
                            🕒 <?php echo date('h:i A', strtotime($clean_start_time)); ?><br>
                            to <?php echo date('h:i A', strtotime($clean_end_time)); ?>
                        </td>
                        <td><small class="text-muted"><?php echo !empty($row['description']) ? nl2br(htmlspecialchars($row['description'])) : '-'; ?></small></td>
                        <td><span class="<?php echo $status_badge; ?>"><?php echo $current_status; ?></span></td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                <?php if($current_status == 'Pending') { ?>
                                    <a href="campaigns.php?approve_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white fw-bold" onclick="return confirm('Approve this user proposed campaign?')">✔ Approve</a>
                                Aminated
                                <?php } ?>

                                <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">✏️</button>

                                <?php if($current_status == 'Upcoming' || $current_status == 'Pending') { ?>
                                    <button type="button" class="btn btn-success btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#completeModal<?php echo $row['id']; ?>">✔ Complete</button>
                                <?php } else { ?>
                                    <span class="badge bg-light text-success fw-bold p-2 border">Finished</span>
                                <?php } ?>
                                
                                <a href="campaigns.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this campaign?')">🗑️</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="POST" action="">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">✏️ Edit Campaign - ID: <?php echo $row['id']; ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <input type="hidden" name="campaign_id" value="<?php echo $row['id']; ?>">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Campaign Title</label>
                                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Organizer</label>
                                                <input type="text" name="organizer" class="form-control" value="<?php echo htmlspecialchars($row['organizer']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Location</label>
                                                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($row['location']); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">District</label>
                                                <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($row['district'] ?? ''); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Campaign Date</label>
                                                <input type="date" name="campaign_date" class="form-control" value="<?php echo $row['campaign_date']; ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Start Time</label>
                                                <input type="time" name="start_time" class="form-control" value="<?php echo $clean_start_time; ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">End Time</label>
                                                <input type="time" name="end_time" class="form-control" value="<?php echo $clean_end_time; ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Description</label>
                                            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($row['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_campaign" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Complete Modal -->
                    <div class="modal fade" id="completeModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">🩸 Complete Campaign & Add Stock</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <input type="hidden" name="campaign_id" value="<?php echo $row['id']; ?>">
                                        <p class="text-muted">මෙම කඳවුරෙන් එකතු වූ ලේ ප්‍රමාණය සහ දිනය ඇතුළත් කරන්න. එය ස්වයංක්‍රීයවම <strong><?php echo $district_name; ?></strong> දිസ്ත්‍රික්කයේ රෝහලට එකතු වේ.</p>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Collected Date (ලේ එකතු කළ දිනය)</label>
                                            <input type="date" name="collected_date" class="form-control" value="<?php echo $row['campaign_date']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Blood Group</label>
                                            <select name="blood_group" class="form-select" required>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Collected Units</label>
                                            <input type="number" name="units" class="form-control text-start" min="1" placeholder="Ex: 35" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="complete_campaign" class="btn btn-success">Complete & Update Stock</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='9' class='text-center text-muted py-4'>No organized campaigns found in database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    Blood Donation Management System - Admin Dashboard
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function fetchHospitals(districtName) {
    var hospitalSelect = document.getElementById("direct_hospital");
    
    if (districtName === "") {
        hospitalSelect.innerHTML = '<option value="">-- Select District First --</option>';
        return;
    }

    var xhr = new XMLHttpRequest();
    // ඔබගේ AJAX පිටුවට නිවැරදි Path එක ලබා දී ඇති බව තහවුරු කරගන්න (e.g. get_hospitals.php)
    xhr.open("GET", "get_hospitals.php?district=" + encodeURIComponent(districtName), true);
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            hospitalSelect.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>
</body>
</html>