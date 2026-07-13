<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

// get Filter Status 
$filter = isset($_GET['expiry_filter']) ? $_GET['expiry_filter'] : 'all';

// SQL Query  - DATEDIFF +42 days
$sql = "SELECT *, 
        DATEDIFF(DATE_ADD(collected_date, INTERVAL 42 DAY), CURDATE()) AS days_remaining 
        FROM blood_stock";

// change query based on filter
if ($filter == 'expired') {
    $sql .= " HAVING days_remaining <= 0";
} elseif ($filter == 'critical') {
    $sql .= " HAVING days_remaining > 0 AND days_remaining <= 7"; // we can also use "BETWEEN 1 AND 7" instead of "> 0 AND <= 7"
} elseif ($filter == 'safe') {
    $sql .= " HAVING days_remaining > 7";
}

$sql .= " ORDER BY days_remaining ASC"; 
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Stock Expiry Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: white; }
        .report-header { border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 30px; }
        .table th { background-color: #198754 !important; color: white !important; text-align: center; }
        @media print { .no-print { display: none !important; } }
        .status-badge { font-weight: bold; padding: 5px 10px; border-radius: 20px; font-size: 14px; }
    </style>
</head>
<body class="p-4">

    <div class="d-flex justify-content-between align-items-center no-print mb-4 p-3 bg-light rounded shadow-sm">
        <div>
            <form method="GET" action="" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="fw-bold text-dark"><i class="fas fa-filter text-success"></i> Filter by Expiry Days:</label>
                </div>
                <div class="col-auto">
                    <select name="expiry_filter" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Stock (සියල්ල)</option>
                        <option value="safe" <?php echo $filter == 'safe' ? 'selected' : ''; ?>>Safe Stock (> 7 Days)</option>
                        <option value="critical" <?php echo $filter == 'critical' ? 'selected' : ''; ?>>Critical (Expires within 7 Days)</option>
                        <option value="expired" <?php echo $filter == 'expired' ? 'selected' : ''; ?>>Expired (කල් ඉකුත් වූ ඒවා)</option>
                    </select>
                </div>
            </form>
        </div>
        <div>
            <button onclick="window.print();" class="btn btn-success fw-bold"><i class="fas fa-print"></i> Print / Download PDF</button>
        </div>
    </div>

    <div class="report-header text-center">
        <h2 style="color: #198754; font-weight: bold;">BLOOD DONATION MANAGEMENT SYSTEM</h2>
        <h5>Current Available Blood Stock & Expiry Report</h5>
        <p class="text-muted small mb-0">Generated Date: <?php echo date('Y-m-d h:i A'); ?></p>
        <p class="badge bg-secondary no-print mt-2">Active Filter: <?php echo ucfirst($filter); ?></p>
    </div>

    <br>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Blood Group</th>
                <th>Available Quantity</th>
                <th>Hospital / Location</th>
                <th>Collected Date</th>
                <th>Days Remaining (ඉතිරි දින ගණන)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $days = $row['days_remaining'];
                    
                    // determine status and badge class based on days remaining
                    if ($days <= 0) {
                        $status_text = "Expired";
                        $badge_class = "bg-danger text-white";
                        $days_text = "Expired (" . abs($days) . " days ago)";
                        $row_class = "table-danger"; // this row will be highlighted in red
                    } elseif ($days <= 7) {
                        $status_text = "Urgent / Critical";
                        $badge_class = "bg-warning text-dark";
                        $days_text = $days . " Days Left";
                        $row_class = "table-warning"; // this row will be highlighted in yellow
                    } else {
                        $status_text = "Safe";
                        $badge_class = "bg-success text-white";
                        $days_text = $days . " Days Left";
                        $row_class = "";
                    }

                    echo "<tr class='{$row_class}'>
                            <td class='text-center'><strong>" . htmlspecialchars($row['blood_group']) . "</strong></td>
                            <td class='text-center'>{$row['units']} Units</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td class='text-center'>" . htmlspecialchars($row['collected_date']) . "</td>
                            <td class='text-center fw-bold'>{$days_text}</td>
                            <td class='text-center'><span class='status-badge {$badge_class}'>{$status_text}</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No Blood Stock Records Found for this filter.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>