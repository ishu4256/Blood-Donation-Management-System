<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

$result = $conn->query("SELECT * FROM hospitals ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Report PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: white; }
        .report-header { border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 30px; }
        .table th { background-color: #0d6efd !important; color: white !important; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="p-4">

    <div class="d-flex justify-content-between align-items-center no-print mb-4">
        <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        <button onclick="window.print()" class="btn btn-primary">📥 Download / Print PDF</button>
    </div>

    <div class="report-header text-center">
        <h2 style="color: #0d6efd; font-weight: bold;">BLOOD DONATION MANAGEMENT SYSTEM</h2>
        <h5>Registered Hospitals Report</h5>
        <p class="text-muted small">Generated Date: <?php echo date('Y-m-d h:i A'); ?></p>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Hospital ID</th>
                <th>Hospital Name</th>
                <th>Location / Address</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td><strong>" . htmlspecialchars($row['name']) . "</strong></td>
                            <td>📍 " . htmlspecialchars($row['location']) . "</td>
                            <td>{$row['contact']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No Hospitals Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>