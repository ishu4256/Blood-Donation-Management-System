<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

/* 💡 නිවැရදි කිරීම:
   collected_date එකට දින 42ක් එකතු කර, එය අද දිනය සමඟ සසඳා 
   ඉතිරි දින ගණන (days_remaining) ගණනය කරනු ලබයි.
*/
$sql = "SELECT *, 
        DATEDIFF(DATE_ADD(collected_date, INTERVAL 42 DAY), CURDATE()) AS days_remaining 
        FROM blood_stock 
        ORDER BY id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Stock Report PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: white; }
        .report-header { border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 30px; }
        .table th { background-color: #198754 !important; color: white !important; text-align: center; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="p-4">

    <div class="d-flex justify-content-between align-items-center no-print mb-4">
        <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        <button onclick="window.print()" class="btn btn-success">📥 Download / Print PDF</button>
    </div>

    <div class="report-header text-center">
        <h2 style="color: #198754; font-weight: bold;">BLOOD DONATION MANAGEMENT SYSTEM</h2>
        <h5>Current Available Blood Stock & Safety Status Report</h5>
        <p class="text-muted small">Generated Date: <?php echo date('Y-m-d h:i A'); ?></p>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Blood Group</th>
                <th>Hospital / Center Name</th>
                <th>Available Quantity</th>
                <th>Collected Date</th>
                <th>Expiry Date</th>
                <th style="width: 180px;">Safety Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $collected = $row['collected_date'];
                    // දින 42 එකතු කර Expiry Date එක සාදා ගැනීම
                    $expiry = date('Y-m-d', strtotime($collected . ' + 42 days')); 
                    $days_left = $row['days_remaining'];

                    // තත්ත්වය සහ වර්ණ තීරණය කිරීම (Status and Color Logic)
                    if ($days_left < 0) {
                        $status_badge = "<span class='badge bg-danger d-block py-2 fs-6'>❌ Expired</span>";
                        $expiry_text = "<span class='text-danger fw-bold'>$expiry</span>";
                    } elseif ($days_left <= 5) {
                        $status_badge = "<span class='badge bg-warning text-dark d-block py-2 fs-6'>⚠️ Near Expiry ($days_left days left)</span>";
                        $expiry_text = "<span class='text-warning fw-bold'>$expiry</span>";
                    } else {
                        $status_badge = "<span class='badge bg-success d-block py-2 fs-6'>✅ Safe ($days_left days left)</span>";
                        $expiry_text = "<span class='text-success fw-bold'>$expiry</span>";
                    }

                    echo "<tr>
                            <td class='text-center fs-5'><strong>" . htmlspecialchars($row['blood_group']) . "</strong></td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td class='text-center fw-bold'>" . htmlspecialchars($row['units']) . " Units</td>
                            <td class='text-center'>" . htmlspecialchars($collected) . "</td>
                            <td class='text-center'>{$expiry_text}</td>
                            <td class='text-center'>{$status_badge}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center text-muted py-4'>No Blood Stock Records Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>