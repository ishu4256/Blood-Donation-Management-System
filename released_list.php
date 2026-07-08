<?php
session_start();

// Admin ද යන්න පරීක්ෂාව
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error){ die("Connection Failed : " . $conn->connect_error); }

// රිලීස් කරපු දත්ත අලුත්ම ඒවා මුලට එන සේ ලබා ගැනීම
$query = "SELECT * FROM blood_releases ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Released Blood History - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .topbar { background: #2c3e50; color: white; padding: 15px; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 30px; }
        .table th { background-color: #2c3e50 !important; color: white !important; }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Admin Dashboard</h3>
    <div>
        <a href="boking.php" class="btn btn-light btn-sm me-2">Blood Bookings</a>
        <a href="login.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
</div>

<div class="container mb-5">
    <div class="container-box">
        <h2 class="text-center mb-4" style="color: #2c3e50; font-weight: bold;">📋 Released Blood History Log</h2>
        
        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Bookings</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Release ID</th>
                        <th>Booking ID</th>
                        <th>Patient / Requester Name</th>
                        <th>Hospital Name</th>
                        <th>Address</th>
                        <th>Blood Group</th>
                        <th>Units Released</th>
                        <th>Released Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><span class="badge bg-secondary">#REL-<?php echo $row['id']; ?></span></td>
                        <td>#BOK-<?php echo $row['booking_id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['patient_name']); ?></strong></td>
                        <td>📍 <?php echo htmlspecialchars($row['hospital_name']); ?></td>
                        <td>🏠 <?php echo htmlspecialchars($row['address']); ?></td>
                        <td><span class="badge bg-danger fs-6"><?php echo htmlspecialchars($row['blood_group']); ?></span></td>
                        <td class="fw-bold text-success"><?php echo $row['units']; ?> Bags</td>
                        <td class="small text-muted"><?php echo date('Y-m-d h:i A', strtotime($row['released_at'])); ?></td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        // 💡 මෙන්න මෙතන Colspan එක 8 කලා ටේබල් එක ලස්සනට පේන්න
                        echo "<tr><td colspan='8' class='text-center text-muted py-4'>No blood release records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>