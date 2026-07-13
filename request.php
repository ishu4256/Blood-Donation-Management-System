<?php
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "blood_donations"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//   MANUAL APPROVE
if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']);
    
    //  Blood Group සහ Units ganna eka
    $req_check = $conn->query("SELECT blood_group, units FROM requests WHERE id=$approve_id");
    
    if ($req_check && $req_check->num_rows > 0) {
        $req_data = $req_check->fetch_assoc();
        $b_group = $req_data['blood_group'];
        $b_units = intval($req_data['units']);

        // Stock eke me bload ek thiyanwada balanna
        $stock_check = $conn->query("SELECT id, units FROM blood_stock WHERE blood_group='$b_group' AND units >= $b_units LIMIT 1");

        if ($stock_check && $stock_check->num_rows > 0) {
            $stock_data = $stock_check->fetch_assoc();
            $stock_id = $stock_data['id'];

            //  Transaction start karanna
            $conn->begin_transaction();
            try {
                // A. Request   Approved karana
                $conn->query("UPDATE requests SET status='Approved' WHERE id=$approve_id");

                // B. Stock eken adu karanna (Automatic Update)
                $conn->query("UPDATE blood_stock SET units = units - $b_units WHERE id=$stock_id");

                $conn->commit();
                echo "<script>alert('🎉 Blood request approved and stock updated successfully!'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
            } catch (Exception $e) {
                $conn->rollback();
                echo "<script>alert('Error updating stock: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('⚠️ Cannot Approve! Insufficient stock available in the system.');</script>";
        }
    }
}

// 🔄 2. AUTO-PROCESS: 
if (isset($_POST['add_request'])) {
    
    $patient_name  = $conn->real_escape_string($_POST['patient_name']);
    $blood_group   = $conn->real_escape_string($_POST['blood_group']);
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $required_date = $conn->real_escape_string($_POST['date']);
    $requested_units = intval($_POST['units']); // අලුතින් එකතු කල බෑග් ගණන

    $stock_query = $conn->query("SELECT id, units FROM blood_stock WHERE blood_group = '$blood_group' AND units >= $requested_units LIMIT 1");

    $conn->begin_transaction();
    try {
        if ($stock_query && $stock_query->num_rows > 0) {
            $stock_row = $stock_query->fetch_assoc();
            $stock_id = $stock_row['id'];

            // A. Requests table eke Approved kiyala watena
            $conn->query("INSERT INTO requests (patient_name, blood_group, units, hospital_name, status, date) 
                          VALUES ('$patient_name', '$blood_group', $requested_units, '$hospital_name', 'Approved', '$required_date')");

            // B. Stock eken aduwenna automaticaly
            $conn->query("UPDATE blood_stock SET units = units - $requested_units WHERE id = $stock_id");

            $conn->commit();
            echo "<script>alert('🎉 Stock Available! Request approved and stock updated automatically.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        } else {
            // thoga nathnm AUTO PENDING
            $conn->query("INSERT INTO requests (patient_name, blood_group, units, hospital_name, status, date) 
                          VALUES ('$patient_name', '$blood_group', $requested_units, '$hospital_name', 'Pending', '$required_date')");
            
            $conn->commit();
            echo "<script>alert('⚠️ Out of Stock! Request submitted as Pending.'); window.location.href='" . basename($_SERVER['PHP_SELF']) . "';</script>";
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$query = "SELECT * FROM requests ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; }
        .container-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .badge-approved { background-color: #28a745; color: white; padding: 6px 12px; border-radius: 20px; font-size: 13px; }
        .badge-pending { background-color: #ffc107; color: #212529; padding: 6px 12px; border-radius: 20px; font-size: 13px; }
        .table th { background-color: #8e0000 !important; color: white !important; }
    </style>
</head>
<body class="p-4">

<div class="container mb-5">
    <div class="container-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">🩸 Blood Requests Management</h2>
            <button type="button" class="btn btn-danger fw-bold px-4 py-2 shadow-sm" style="background-color: #8e0000; border:none;" data-bs-toggle="modal" data-bs-target="#requestBloodModal">
                + Request Blood Now
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Blood Group</th>
                        <th>Units (Bags)</th>
                        <th>Hospital Name</th>
                        <th>Required Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $status_class = ($row['status'] == 'Approved') ? 'badge-approved' : 'badge-pending';
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['patient_name']); ?></strong></td>
                        <td><span class="text-danger fw-bold"><?php echo htmlspecialchars($row['blood_group']); ?></span></td>
                        <td><strong><?php echo isset($row['units']) ? $row['units'] : '1'; ?> Units</strong></td>
                        <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><span class="<?php echo $status_class; ?>"><?php echo $row['status']; ?></span></td>
                        <td>
                            <?php if($row['status'] == 'Pending') { ?>
                                <a href="?approve_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success fw-bold" onclick="return confirm('Approve this request and update stock?')">Approve</a>
                            <?php } else { ?>
                                <button class="btn btn-sm btn-secondary" disabled>Done</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>