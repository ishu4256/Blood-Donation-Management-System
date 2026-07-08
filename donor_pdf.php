<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

$result = $conn->query("SELECT * FROM donor ORDER BY donor_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Report PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: white; color: black; }
        .report-header { border-bottom: 2px solid #8e0000; padding-bottom: 10px; margin-bottom: 30px; }
        .table th { background-color: #8e0000 !important; color: white !important; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body class="p-4">

    <div class="d-flex justify-content-between align-items-center no-print mb-4">
        <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        <button onclick="window.print()" class="btn btn-danger">📥 Download / Print PDF</button>
    </div>

    <div class="report-header text-center">
        <h2 style="color: #8e0000; font-weight: bold;">BLOOD DONATION MANAGEMENT SYSTEM</h2>
        <h5>Total Registered Donors Report</h5>
        <p class="text-muted small">Generated Date: <?php echo date('Y-m-d h:i A'); ?></p>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Donor ID</th>
                <th>Full Name</th>
                <th>Blood Group</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['donor_id']}</td>
                            <td><strong>" . htmlspecialchars($row['full_name']) . "</strong></td>
                            <td><span class='badge bg-danger'>{$row['blood_group']}</span></td>
                            <td>{$row['phone']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No Donors Found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // පිටුවට ආ සැනින් Print Dialog එක auto open වීමට අවශ්‍ය නම්:
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>