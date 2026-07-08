<?php
// Session එක පරීක්ෂා කිරීම (User ලොගින් වී සිටිය යුතුය)
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$message = "";
$message_class = "";

// ➕ USER DIRECTLY ADD CAMPAIGN LOGIC (පරිශීලකයා කඳවුරක් එකතු කිරීමේ කේතය)
if(isset($_POST['add_user_campaign'])){
    $title = $conn->real_escape_string($_POST['title']);
    $organizer = $conn->real_escape_string($_POST['organizer']);
    $location = $conn->real_escape_string($_POST['location']);
    $district = $conn->real_escape_string($_POST['district']);
    $campaign_date = $conn->real_escape_string($_POST['campaign_date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $description = $conn->real_escape_string($_POST['description']);

    // පරිශීලකයෙක් ඇතුළත් කරන නිසා status එක default 'Pending' වේ
    $sql = "INSERT INTO campaigns (title, organizer, location, district, campaign_date, start_time, end_time, description, status) 
            VALUES ('$title', '$organizer', '$location', '$district', '$campaign_date', '$start_time', '$end_time', '$description', 'Pending')";

    if($conn->query($sql)){
        $message = "🎉 Campaign request submitted successfully! Waiting for Admin approval.";
        $message_class = "alert-success";
    } else {
        $message = "❌ Error occurred while adding the campaign.";
        $message_class = "alert-danger";
    }
}

// 🔍 FILTER LOGIC (කඳවුරු පෙිරීමේ කේතය)
// පරිශීලකයා කිසිවක් තෝරා නොමැති නම් මුලින්ම පෙන්වන්නේ 'Upcoming' කඳවුරු පමණි.
$selected_filter = 'Upcoming'; 

if(isset($_GET['status_filter']) && ($_GET['status_filter'] == 'Upcoming' || $_GET['status_filter'] == 'Completed')) {
    $selected_filter = $_GET['status_filter'];
}

// තෝරාගත් Status එක අනුව පමණක් දත්ත සමුදායෙන් දත්ත ලබා ගැනීම (Pending ඒවා පොදුවේ පෙන්වන්නේ නැත)
$filter_status_escaped = $conn->real_escape_string($selected_filter);
$result = $conn->query("SELECT * FROM campaigns WHERE status = '$filter_status_escaped' ORDER BY campaign_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blood Donation Campaigns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .topbar { background: #8e0000; color: white; padding: 15px; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 20px; }
        h2, h3, h4 { color: #8e0000; font-weight: bold; }
        .table th { background-color: #8e0000 !important; color: white !important; }
        .badge-upcoming { background-color: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .badge-completed { background-color: #198754; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        footer { background: #8e0000; color: white; text-align: center; padding: 15px; margin-top: 50px; }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Campaigns</h3>
     <div class="text-center mt-4">
    <button type="button" class="btn btn-secondary ms-2" style="width: 140px; padding: 9px 0;" onclick="window.close();">Back</button>
</div>
</div>

<div class="container mb-5">
    
    <?php if(!empty($message)): ?>
        <div class="alert <?php echo $message_class; ?> alert-dismissible fade show mt-3" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container-box border-start border-danger border-4">
        <h4>📢 Propose a New Blood Donation Campaign (නව ලේ දීමේ කඳවුරක් යෝජනා කරන්න)</h4>
        <p class="text-muted small">ඔබේ ප්‍රදේශයේ සංවිධානය කරන ලේ දීමේ කඳවුරේ විස්තර නිවැරදිව ඇතුළත් කරන්න. පරිපාලක (Admin) අනුමැතියෙන් පසු එය ප්‍රදර්ශනය කෙරේ.</p>
        
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Campaign Title (කඳවුරේ නම)</label>
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Ex: Annual Blood Drive 2026" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Organizer (සංවිධායක මණ්ඩලය)</label>
                    <input type="text" name="organizer" class="form-control form-control-sm" placeholder="Ex: Leo Club of Matara" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Location / Venue (ස්ථානය)</label>
                    <input type="text" name="location" class="form-control form-control-sm" placeholder="Ex: Town Hall" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">District (දිස්ත්‍රික්කය)</label>
                    <select name="district" class="form-select form-select-sm" required>
                        <option value="">-- Select District --</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Matale">Matale</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Galle">Galle</option>
                        <option value="Matara">Matara</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Badulla">Badulla</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Campaign Date (දිනය)</label>
                    <input type="date" name="campaign_date" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Start Time (ආරම්භක වේලාව)</label>
                    <input type="time" name="start_time" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">End Time (අවසාන වේලාව)</label>
                    <input type="time" name="end_time" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Brief Description (කෙටි විස්තරයක්)</label>
                    <input type="text" name="description" class="form-control form-control-sm" placeholder="Ex: Contact numbers or special notes">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="add_user_campaign" class="btn btn-danger btn-sm fw-bold px-4">
                        📢 Submit Campaign Request
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-box">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <h3>🗓️ Blood Donation Campaigns List</h3>
            
            <!-- 🔍 Filter Form (තෝරාගැනීමේ කොටස) -->
            <form method="GET" action="" class="d-flex align-items-center gap-2">
                <label for="status_filter" class="fw-bold small text-nowrap mb-0">Filter Status:</label>
                <select name="status_filter" id="status_filter" class="form-select form-select-sm" style="width: 160px;" onchange="this.form.submit()">
                    <option value="Upcoming" <?php if($selected_filter == 'Upcoming') echo 'selected'; ?>>Upcoming Campaigns</option>
                    <option value="Completed" <?php if($selected_filter == 'Completed') echo 'selected'; ?>>Completed Campaigns</option>
                </select>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Campaign Title</th>
                        <th>Organizer</th>
                        <th>Location & District</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $current_status = (!empty($row['status'])) ? $row['status'] : 'Upcoming';
                            
                            if($current_status == 'Completed'){
                                $status_badge = 'badge-completed';
                            } else {
                                $status_badge = 'badge-upcoming';
                            }

                            $district_name = (!empty($row['district'])) ? htmlspecialchars($row['district']) : "Not Set";
                            
                            $clean_start_time = substr($row['start_time'], 0, 8);
                            $clean_end_time = substr($row['end_time'], 0, 8);
                    ?>
                    <tr>
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
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted py-4'>No " . htmlspecialchars(strtolower($selected_filter)) . " campaigns found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    Blood Donation Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>