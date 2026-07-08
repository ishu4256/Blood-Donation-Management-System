<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Trim කිරීම මඟින් අනවශ්‍ය හිස්තැන් (Spaces) ඉවත් කරයි
$province = isset($_GET['province']) ? trim($conn->real_escape_string($_GET['province'])) : '';
$district = isset($_GET['district']) ? trim($conn->real_escape_string($_GET['district'])) : '';
$result = null;

if (!empty($province) && !empty($district)) {
    // 💡 LOWER() භාවිතයෙන් කැපිටල්/සිම්පල් ප්‍රශ්න මඟහරවා ගනී. 
    // % ලකුණ මඟින් අගයට සමාන ඕනෑම දත්තයක් (LIKE) සොයා දෙයි.
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
    <title>Search Donors Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">
<div class="container bg-white p-4 rounded shadow-sm">
    <h3 class="text-danger mb-4">Donors in <?php echo htmlspecialchars($district); ?> District (<?php echo htmlspecialchars($province); ?> Province)</h3>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Blood Group</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Phone</th>
                    <th>Availability Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td class='text-center fw-bold text-danger'>" . htmlspecialchars($row['blood_group']) . "</td>
                                <td>" . htmlspecialchars($row['Province']) . "</td>
                                <td>" . htmlspecialchars($row['Districrt']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td><span class='badge " . ($row['availability_status'] == 'Available' ? 'bg-success' : 'bg-secondary') . "'>" . htmlspecialchars($row['availability_status']) . "</span></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center text-muted py-3'>No donors found for the selected area.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>