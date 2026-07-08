<?php
// පරිශීලකයන් සඳහා වන නිසා session_start හෝ admin පරීක්ෂාවන් ඉවත් කර ඇත.
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

$selected_blood = "";
$result = null;

// පරිශීලකයා ලේ වර්ගයක් තෝරා සෙවූ විට ක්‍රියාත්මක වන කොටස
if (isset($_POST['search'])) {
    $selected_blood = $conn->real_escape_string($_POST['blood_group']);
    
    if (!empty($selected_blood)) {
        // 💡 වෙනස් කරන ලද SQL Query එක: 
        // 1. තෝරාගත් ලේ වර්ගය සහ බෑග් ගණන 0ට වැඩි විය යුතුයි.
        // 2. එකතු කල දිනයේ සිට දින 42ක් පිරී (Expired වී) නොතිබිය යුතුයි (HAVING days_remaining > 0).
        $sql = "SELECT *, 
                DATEDIFF(DATE_ADD(collected_date, INTERVAL 42 DAY), CURDATE()) AS days_remaining 
                FROM blood_stock 
                WHERE blood_group = '$selected_blood' AND units > 0 
                HAVING days_remaining > 0
                ORDER BY days_remaining ASC";
                
        $result = $conn->query($sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Blood Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; }
        .main-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .page-header { border-bottom: 3px solid #dc3545; padding-bottom: 15px; margin-bottom: 25px; }
        .table th { background-color: #dc3545 !important; color: white !important; }
    </style>
</head>
<body class="py-5">

<div class="container" style="max-width: 850px;">
    <div class="main-card">
        
        <div class="page-header text-center">
            <h2 class="fw-bold text-danger">🩸 BLOOD AVAILABILITY SEARCH</h2>
            <p class="text-muted mb-0">Find real-time available blood stocks in nearby hospitals</p>
        </div>

        <form method="POST" action="" class="mb-4">
            <div class="row g-2 justify-content-center">
                <div class="col-md-6">
                    <select class="form-select form-select-lg border-danger" name="blood_group" required>
                        <option value="" selected disabled>-- Select Required Blood Group --</option>
                        <?php 
                        $bg_options = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                        foreach($bg_options as $bg) {
                            $sel = ($selected_blood == $bg) ? 'selected' : '';
                            echo "<option value='$bg' $sel>$bg</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="search" class="btn btn-danger btn-lg w-100 fw-bold">Check Availability</button>
                </div>
                 
            </div>
        </form>

        <?php if (isset($_POST['search'])) { ?>
            <div class="mt-4">
                <h5 class="mb-3 fw-bold text-secondary">
                    Search Results for Blood Group: <span class="badge bg-danger fs-6 px-3"><?php echo htmlspecialchars($selected_blood); ?></span>
                </h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="60%">Hospital / Location Name</th>
                                <th width="40%" class="text-center">Available Quantity (Units)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>
                                                <strong class='text-dark'>📍 " . htmlspecialchars($row['name']) . "</strong>";
                                                // ටේබල් එකේ district කොලම් එකක් ඇත්නම් එයද පෙන්වීමට
                                                if(!empty($row['district'])) {
                                                    echo "<br><small class='text-muted ms-3'>District: " . ucwords(htmlspecialchars($row['district'])) . "</small>";
                                                }
                                    echo "  </td>
                                            <td class='text-center'>
                                                <span class='badge bg-success fs-6 px-3 py-2'>{$row['units']} Bags Available</span>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' class='text-center text-muted py-4'>❌ Sorry! No active/safe blood stocks available for <strong>$selected_blood</strong> at this moment.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="text-center mt-4">
        <button type="button" class="btn btn-secondary ms-2" style="width: 140px; padding: 9px 0;" onclick="window.close();">Back</button>
    </div>
   
</div>

</body>
</html>