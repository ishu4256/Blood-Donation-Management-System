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
$result = null;

if (!empty($province) && !empty($district)) {
    $sql = "SELECT * FROM donor 
            WHERE LOWER(Province) LIKE LOWER('%$province%') 
            AND LOWER(Districrt) LIKE LOWER('%$district%') 
            ORDER BY full_name ASC";
            
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Donors Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* 💡 Dashboard එකට සමාන Background Image එක */
background: #31080c;    
        background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 15px;
        }
        
        .result-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .header-title {
            color: #8e0000;
            font-weight: 700;
            border-left: 5px solid #8e0000;
            padding-left: 15px;
        }

        /* 💡 Table Head එකට රතු/තද පැහැති Gradient එකක් දමා ඇත */
        .table-custom-dark {
            background: linear-gradient(135deg, #8e0000, #c0392b);
            color: white;
        }

        .table-custom-dark th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
            border: none;
            padding: 12px;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(142, 0, 0, 0.03) !important;
        }

        .blood-badge {
            font-size: 16px;
            font-weight: 800;
            color: #dc3545;
            background: #fdf2f2;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 20px;
            border: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #495057;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>

<div class="container" style="max-width: 1100px;">
    <div class="result-container">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h3 class="header-title m-0">
                Donors in <span class="text-dark"><?php echo htmlspecialchars($district); ?></span> District 
                <small class="text-muted fs-5">(<?php echo htmlspecialchars($province); ?> Province)</small>
            </h3>
            <a href="admin_dashboard.php" class="btn btn-back mt-2 mt-md-0">⬅ Back to Dashboard</a>
        </div>
        
        <!-- Results Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-custom-dark text-center">
                    <tr>
                        <th class="text-start">Donor Name</th>
                        <th>Blood Group</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>Phone Number</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Status එක අනුව Badge එකේ පාට වෙනස් කිරීම
                            $status_class = (trim($row['availability_status']) == 'Available') ? 'bg-success' : 'bg-secondary';
                            
                            echo "<tr>
                                    <td class='fw-semibold text-dark text-start'>" . htmlspecialchars($row['full_name']) . "</td>
                                    <td class='text-center'><span class='blood-badge'>" . htmlspecialchars($row['blood_group']) . "</span></td>
                                    <td class='text-center text-muted'>" . htmlspecialchars($row['Province']) . "</td>
                                    <td class='text-center text-muted'>" . htmlspecialchars($row['Districrt']) . "</td>
                                    <td class='text-center fw-mono'>" . htmlspecialchars($row['phone']) . "</td>
                                    <td class='text-center'><span class='badge " . $status_class . " px-3 py-2' style='border-radius:6px;'>" . htmlspecialchars($row['availability_status']) . "</span></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted py-5 fs-5'>❌ No donors found for the selected area.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>