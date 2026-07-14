<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$sql = "SELECT * FROM donor_details ORDER BY donor_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Details Master List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-image: linear-gradient(rgba(9, 11, 15, 0.8), rgba(30, 35, 41, 0.9)), url('images/bc.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }
        .container-box { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            margin-top: 40px; 
            margin-bottom: 40px;
            color: #333;
        }
        .table th { 
            background-color: #8e0000 !important; 
            color: white !important; 
            text-align: center; 
        }
    </style>
</head>
<body>

<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="container-box">

                <div class="border-bottom pb-2 mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="text-danger fw-bold m-0">📋 Donor Comprehensive Details</h2>
                    <a href="dashboard.php" class="btn btn-secondary fw-bold">← Back to Dashboard</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>NIC</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Blood Group</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>Gender</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo $row['donor_id']; ?></strong></td>
                                        <td class="text-start"><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['nic']); ?></td>
                                        <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                                        <td class="text-start"><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><span class="badge bg-danger fs-6"><?php echo htmlspecialchars($row['blood_group']); ?></span></td>
                                        <td><?php echo htmlspecialchars($row['province']); ?></td>
                                        <td><?php echo htmlspecialchars($row['district']); ?></td>
                                        <td><?php echo htmlspecialchars($row['sex']); ?></td>
                                        <td class="text-start small"><?php echo htmlspecialchars($row['address']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-muted py-4 fs-5">No records found in donor_details table.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>