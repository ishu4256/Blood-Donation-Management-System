<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$province = isset($_GET['province']) ? trim($conn->real_escape_string($_GET['province'])) : '';
$district = isset($_GET['district']) ? trim($conn->real_escape_string($_GET['district'])) : '';
$blood_group = isset($_GET['blood_group']) ? trim($conn->real_escape_string($_GET['blood_group'])) : '';
$result = null;

if (!empty($province) && !empty($district) && !empty($blood_group)) {
    // 💡 මෙහිද LOWER() සහ LIKE භාවිතා කර ඇත
    $sql = "SELECT * FROM donor 
            WHERE LOWER(Province) LIKE LOWER('%$province%') 
            AND LOWER(Districrt) LIKE LOWER('%$district%') 
            AND blood_group = '$blood_group' 
            ORDER BY full_name ASC";
            
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Blood Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #31080c;
            font-family: Arial;
        }
        .container-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            margin-top: 30px;
        }
        h2 {
            color: #8e0000;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="container-box">
        <h2 class="text-center mb-4">Blood Search Results</h2>
        <p class="text-muted text-center">
            Showing <b><span class="text-danger"><?php echo htmlspecialchars($blood_group); ?></span></b> Donors in 
            <b><?php echo htmlspecialchars($district); ?></b>, <b><?php echo htmlspecialchars($province); ?> Province</b>
        </p>

        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

        <table class="table table-bordered table-striped">
            <tr class="table-danger" style="background-color: #8e0000; color: white;">
                <th>ID</th>
                <th>Donor Name</th>
                <th>Blood Group</th>
                <th>District</th>
                <th>Contact (Phone)</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>

            <?php 
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
            ?>
            <tr>
                <td><?php echo $row['donor_id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><span class="badge bg-danger"><?php echo $row['blood_group']; ?></span></td>
                <td><?php echo $row['Districrt']; ?></td> 
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <?php if($row['availability_status'] == 'Available') { ?>
                        <span class="badge bg-success">Available</span>
                    <?php } else { ?>
                        <span class="badge bg-secondary">Unavailable</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="edit_donor.php?id=<?php echo $row['donor_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_donor.php?id=<?php echo $row['donor_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this donor?')">Delete</a>
                </td>
            </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='7' class='text-center text-danger'>No matching blood donors found for the selected area.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>