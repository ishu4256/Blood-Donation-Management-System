<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
if($_SESSION['role'] != 'admin'){
    header("Location: Dashboard.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}


if(isset($_POST['add_request'])){
    $name = $conn->real_escape_string($_POST['patient_name']); 
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $date = $conn->real_escape_string($_POST['date']);
    $requested_units = isset($_POST['units']) ? intval($_POST['units']) : 1; 
    $status = "Pending"; 

    // system eke me bload ona tharam thiyedai balanna
    $stock_query = $conn->query("SELECT id, units FROM blood_stock WHERE blood_group = '$blood_group' AND units >= $requested_units LIMIT 1");

    $conn->begin_transaction();
    try {
        if ($stock_query && $stock_query->num_rows > 0) {
            // stock thiynawanm AUTO APPROVE & DEDUCT FROM STOCK
            $stock_row = $stock_query->fetch_assoc();
            $stock_id = $stock_row['id'];

            //  Requests table ekata Approved lesa watima
            $conn->query("INSERT INTO requests (patient_name, blood_group, units, hospital_name, status, date) 
                          VALUES ('$name', '$blood_group', $requested_units, '$hospital_name', 'Approved', '$date')");

            // B. Stock eken automaticaly adu wima
            $conn->query("UPDATE blood_stock SET units = units - $requested_units WHERE id = $stock_id");

            // C. Blood Releases table ekata data add kirima
            $last_id = $conn->insert_id;
            $conn->query("INSERT INTO blood_releases (booking_id, patient_name, hospital_name, blood_group, units) 
                          VALUES ($last_id, '$name', '$hospital_name', '$blood_group', $requested_units)");

            $conn->commit();
            echo "<script>alert('🎉 Stock Available! Request approved and stock updated automatically.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        } else {
            // stock nathnm -> AUTO PENDING
            $conn->query("INSERT INTO requests (patient_name, blood_group, units, hospital_name, status, date) 
                          VALUES ('$name', '$blood_group', $requested_units, '$hospital_name', 'Pending', '$date')");
            
            $conn->commit();
            echo "<script>alert('⚠️ Out of Stock! Request submitted as Pending.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
// ====================================================================================


// ==================== MANUAL APPROVE BUTTON CLICK PROCESS ====================
if(isset($_GET['approve_id'])){
    $approve_id = intval($_GET['approve_id']);
    
    // Blood Group සහ Units
    $req_check = $conn->query("SELECT patient_name, blood_group, units, hospital_name FROM requests WHERE id=$approve_id AND status='Pending'");
    
    if ($req_check && $req_check->num_rows > 0) {
        $req_data = $req_check->fetch_assoc();
        $b_name = $conn->real_escape_string($req_data['patient_name']);
        $b_group = $req_data['blood_group'];
        $b_units = intval($req_data['units']);
        $b_hospital = $conn->real_escape_string($req_data['hospital_name']);

        // Stock eke me bload thiyada kiyala balana eka
        $stock_check = $conn->query("SELECT id, units FROM blood_stock WHERE blood_group='$b_group' AND units >= $b_units LIMIT 1");

        if ($stock_check && $stock_check->num_rows > 0) {
            $stock_data = $stock_check->fetch_assoc();
            $stock_id = $stock_data['id'];

            // Transaction ekak start karanna
            $conn->begin_transaction();
            try {
                // A. Request eka Approved kirima
                $conn->query("UPDATE requests SET status='Approved' WHERE id=$approve_id");
                
                // B. Stock eken count adu kirima
                $conn->query("UPDATE blood_stock SET units = units - $b_units WHERE id=$stock_id");

                // C. Blood Releases table data add kirima
                $release_sql = "INSERT INTO blood_releases (booking_id, patient_name, hospital_name, blood_group, units) 
                                VALUES ($approve_id, '$b_name', '$b_hospital', '$b_group', $b_units)";
                $conn->query($release_sql);

                $conn->commit();
                
                echo "<script>alert('🎉 Blood request approved, stock updated and released successfully!'); window.location.href='boking.php';</script>";
                exit();
            } catch (Exception $e) {
                $conn->rollback();
                echo "<script>alert('Error updating stock: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('⚠️ Cannot Approve! Insufficient stock available in the system.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        }
    }
}
// ====================================================================================

$result = $conn->query("SELECT * FROM requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blood Requests - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .topbar { background: #8e0000; color: white; padding: 15px; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 30px; }
        h2 { color: #8e0000; font-weight: bold; }
        .table th { background-color: #8e0000 !important; color: white !important; }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-approved { background-color: #198754; color: white; }
        footer { background: #8e0000; color: white; text-align: center; padding: 15px; margin-top: 50px; }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Admin Panel</h3>
    <div>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm me-2">Admin Dashboard</a>
        <a href="boking.php" class="btn btn-warning btn-sm me-2 fw-bold">View Bookings Page</a>
        <a href="login.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="admin_dashboard.php" class="btn btn-secondary">
                    ← Back to Dashboard
                </a>
            </div>
</div>

<div class="container mb-5">
    <div class="container-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Blood Requests List</h2>
            <button type="button" class="btn btn-danger fw-bold px-4 shadow-sm" style="background-color: #8e0000; border:none;" data-bs-toggle="modal" data-bs-target="#requestBloodModal">
                + Request Blood Now
            </button>
        </div>
        
        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Patient/Requester Name</th>
                        <th>Blood Group Required</th>
                        <th>Units (Bags)</th>
                        <th>Hospital Name</th>
                        <th>Required Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $status_badge = ($row['status'] == 'Approved') ? 'badge-approved' : 'badge-pending';
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['patient_name']); ?></strong></td>
                        <td>
                            <span class="badge bg-danger text-white fs-6 px-3">
                                <?php echo htmlspecialchars($row['blood_group']); ?>
                            </span>
                        </td>
                        <td><strong><?php echo isset($row['units']) ? $row['units'] : '1'; ?> Units</strong></td>
                        <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>
                            <span class="badge <?php echo $status_badge; ?> px-2 py-2">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if($row['status'] != 'Approved') { ?>
                                <a href="?approve_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-success btn-sm px-3 fw-bold" 
                                   onclick="return confirm('Are you sure you want to approve this blood request and update stock?')">
                                    ✔ Approve & Release
                                </a>
                            <?php } else { ?>
                                <span class="text-success fw-bold small">✔ Released to boking.php</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='8' class='text-center text-muted py-4'>No blood requests found in the database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="requestBloodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #8e0000; color: white;">
                <h5 class="modal-title fw-bold">Request Blood / Create New Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="modal-body text-start" style="padding: 25px 20px;">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Patient / Requester Name</label>
                        <input type="text" class="form-control" name="patient_name" placeholder="Enter patient name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Blood Group Required</label>
                            <select class="form-select" name="blood_group" required>
                                <option value="" selected disabled>-- Select --</option>
                                <option value="A+">A+</option><option value="A-">A-</option>
                                <option value="B+">B+</option><option value="B-">B-</option>
                                <option value="AB+">AB+</option><option value="AB-">AB-</option>
                                <option value="O+">O+</option><option value="O-">O-</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Required Quantity (Units)</label>
                            <input type="number" class="form-control" name="units" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hospital Name</label>
                        <input type="text" class="form-control" name="hospital_name" placeholder="e.g., General Hospital Matara" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Required Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_request" class="btn btn-danger" style="background-color: #c0392b; border: none;">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    Blood Donation Management System - Admin Dashboard
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>