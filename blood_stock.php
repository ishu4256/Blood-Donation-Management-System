<?php
// 1. Database එකට සම්බන්ධ වීම
$conn = new mysqli("localhost", "root", "", "blood_donations");

// සම්බන්ධතාවය පරීක්ෂා කිරීම
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 🔍 Filter අගයන් ලබා ගැනීම
$expiry_filter = isset($_GET['expiry_filter']) ? $_GET['expiry_filter'] : 'all';
$blood_filter = isset($_GET['blood_filter']) ? $_GET['blood_filter'] : 'all';

// Base SQL Query එක
$sql = "SELECT *, 
        DATEDIFF(DATE_ADD(collected_date, INTERVAL 42 DAY), CURDATE()) AS days_remaining 
        FROM blood_stock";

$having_conditions = [];
$where_conditions = [];
$params = [];
$types = "";

// 1. Expiry Filter එක (HAVING ලෙස)
if ($expiry_filter == 'expired') {
    $having_conditions[] = "days_remaining <= 0";
} elseif ($expiry_filter == 'critical') {
    $having_conditions[] = "days_remaining > 0 AND days_remaining <= 7";
} elseif ($expiry_filter == 'safe') {
    $having_conditions[] = "days_remaining > 7";
}

// 2. Blood Group Filter එක (WHERE ලෙස)
if ($blood_filter != 'all') {
    $where_conditions[] = "blood_group = ?";
    $params[] = $blood_filter;
    $types .= "s";
}

// WHERE කොන්දේසි එකතු කිරීම
if (count($where_conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

// HAVING කොන්දේසි එකතු කිරීම
if (count($having_conditions) > 0) {
    $sql .= " HAVING " . implode(" AND ", $having_conditions);
}

$sql .= " ORDER BY days_remaining ASC"; 

// Prepared Statement එක නිවැරදිව සකස් කිරීම
$stmt = $conn->prepare($sql);

if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Stock Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #31080c; font-family: Arial, sans-serif; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 30px; }
        h2 { color: #8e0000; font-weight: bold; }
        .table th { background-color: #8e0000 !important; color: white !important; text-align: center; }
        .status-badge { font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 13px; display: inline-block; }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="container-box">
        <h2 class="text-center mb-4">Blood Stock Details</h2>

        <div class="bg-light p-3 rounded border mb-4">
            <form method="GET" action="" id="filterForm" class="row g-3 align-items-center">
                <div class="col-md-5 d-flex align-items-center gap-2">
                    <label class="fw-bold text-dark text-nowrap"><i class="fas fa-calendar-alt text-danger"></i> Expiry Status:</label>
                    <select name="expiry_filter" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" <?php echo $expiry_filter == 'all' ? 'selected' : ''; ?>>All Stock (සියල්ල)</option>
                        <option value="safe" <?php echo $expiry_filter == 'safe' ? 'selected' : ''; ?>>Safe Stock (> 7 Days)</option>
                        <option value="critical" <?php echo $expiry_filter == 'critical' ? 'selected' : ''; ?>>Critical (≤ 7 Days)</option>
                        <option value="expired" <?php echo $expiry_filter == 'expired' ? 'selected' : ''; ?>>Expired (කල් ikuth වූ)</option>
                    </select>
                </div>

                <div class="col-md-5 d-flex align-items-center gap-2">
                    <label class="fw-bold text-dark text-nowrap"><i class="fas fa-tint text-danger"></i> Blood Group:</label>
                    <select name="blood_filter" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" <?php echo $blood_filter == 'all' ? 'selected' : ''; ?>>All Groups</option>
                        <?php 
                        $groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                        foreach($groups as $g) {
                            $sel = ($blood_filter == $g) ? 'selected' : '';
                            echo "<option value='$g' $sel>$g</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2 text-md-end">
                    <?php if($expiry_filter != 'all' || $blood_filter != 'all') { ?>
                        <a href="blood_stock.php" class="btn btn-outline-secondary btn-sm w-100 fw-bold">Clear Filters</a>
                    <?php } ?>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
            <div>
                <a href="release_blood.php" class="btn btn-danger me-2" style="background-color: #8e0000; border: none;">🩸 Release Blood</a>
                <a href="add_blood_stock.php" class="btn btn-success">Add New Blood</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>District</th>
                        <th>Blood Group</th>
                        <th>Units</th>
                        <th>Hospital / Location</th>
                        <th>Collected Date</th>
                        <th>Days Remaining</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $days = $row['days_remaining'];
                            
                            if ($days <= 0) {
                                $status_text = "Expired";
                                $badge_class = "bg-danger text-white";
                                $days_text = "Expired (" . abs($days) . " days ago)";
                                $row_class = "table-danger"; 
                            } elseif ($days <= 7) {
                                $status_text = "Critical";
                                $badge_class = "bg-warning text-dark";
                                $days_text = $days . " Days Left";
                                $row_class = "table-warning"; 
                            } else {
                                $status_text = "Safe";
                                $badge_class = "bg-success text-white";
                                $days_text = $days . " Days Left";
                                $row_class = ""; 
                            }
                    ?>
                    <tr class="<?php echo $row_class; ?>">
                        <td class="text-center"><?php echo htmlspecialchars($row['district']); ?></td>
                        <td class="text-center"><strong><?php echo htmlspecialchars(strtoupper($row['blood_group'])); ?></strong></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['units']); ?> Units</td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['collected_date']); ?></td>
                        <td class="text-center fw-bold"><?php echo $days_text; ?></td>
                        <td class="text-center"><span class="status-badge <?php echo $badge_class; ?>"><?php echo $status_text; ?></span></td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted py-4 fw-bold'>❌ No blood stock records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>