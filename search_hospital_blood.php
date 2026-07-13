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

$province = isset($_GET['province']) ? trim($_GET['province']) : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';
$blood_group = isset($_GET['blood_group']) ? trim($_GET['blood_group']) : '';

$result = null;

if (!empty($province) && !empty($district) && !empty($blood_group)) {
    
    //  sewma wadath sarthaka karaganimata agayan simple akuru bawata path kara % lakuna ekathu kirima
    $province_query = "%" . strtolower($province) . "%";
    $district_query = "%" . strtolower($district) . "%";

    /*  
       1. LOWER() and LIKE capital/simple akuru magaharawa atha
       2. DATEDIFF eken dina 42 n expired una blood ain karala thiyanawa.
       3. Units 0 tawadi units pennanawa danat thiyana.
    */
    $query = "SELECT h.id AS hospital_id, h.name AS hospital_name, h.location, h.contact, h.province, h.district, 
                     bs.id AS stock_id, bs.blood_group, bs.units,
                     DATEDIFF(DATE_ADD(bs.collected_date, INTERVAL 42 DAY), CURDATE()) AS days_remaining
              FROM hospitals h 
              INNER JOIN blood_stock bs ON h.name = bs.name 
              WHERE LOWER(h.province) LIKE ? 
                AND LOWER(h.district) LIKE ? 
                AND bs.blood_group = ? 
                AND bs.units > 0
              HAVING days_remaining > 0
              ORDER BY days_remaining ASC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $province_query, $district_query, $blood_group);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hospital Blood Search Result</title>
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
        <h2 class="text-center mb-4">Hospital Blood Stock Results</h2>
        <p class="text-muted text-center">
            Showing Active <b><span class="text-danger"><?php echo htmlspecialchars($blood_group); ?></span></b> Stock in 
            <b><?php echo htmlspecialchars($district); ?></b>, <b><?php echo htmlspecialchars($province); ?> Province</b>
        </p>

        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Hospital ID</th>
                        <th>Hospital Name</th>
                        <th>Location</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>Contact</th>
                        <th>Blood Group</th>
                        <th>Available Units</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['hospital_id']); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['hospital_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo ucwords(htmlspecialchars($row['province'])); ?></td> 
                        <td><?php echo ucwords(htmlspecialchars($row['district'])); ?></td> 
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td class="text-center"><span class="badge bg-danger fs-6"><?php echo htmlspecialchars($row['blood_group']); ?></span></td>
                        <td>
                            <span class="badge bg-success fs-6 px-3 py-2"><?php echo htmlspecialchars($row['units']); ?> Bags Available</span>
                        </td>
                        <td>
                            <a href="edit_hospital.php?id=<?php echo $row['hospital_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='9' class='text-center text-danger py-4 fw-bold'>❌ No hospitals found with available and safe $blood_group blood stocks in this area.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>