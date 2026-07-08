<?php
session_start();
// මෙතනදී Admin කෙනෙක්ද කියලා පරීක්ෂා කරගන්න (උදා: $_SESSION['role'] == 'admin' වගේ එකක් තියෙනවා නම්)
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') { ... }

$conn = new mysqli("localhost", "root", "", "blood_donations");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// අලුත්ම Feedback උඩට එන ලෙස දත්ත ලබා ගැනීම
$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - User Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .admin-container { max-width: 900px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .table-header { background-color: #8e0000; color: white; }
    </style>
</head>
<body><br><br><br><center>
<a href="admin_dashboard.php"
        class="btn btn-secondary mb-3">
            Back
        </a>
</center>
<div class="container">
    <div class="admin-container">
        <h2 class="mb-4 text-center" style="color: #8e0000; font-weight: bold;">User Feedbacks & Suggestions</h2>
        <hr>
        
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-header text-center">
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 22%;">Username</th>
                        <th style="width: 50%;">Feedback Message</th>
                        <th style="width: 20%;">Submitted Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $date = date("Y-m-col M d - h:i A", strtotime($row['submitted_at']));
                            echo "<tr>";
                            echo "<td class='text-center fw-bold'>" . $row['id'] . "</td>";
                            echo "<td class='fw-bold text-secondary'>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                            echo "<td class='text-center text-muted small'>" . $date . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>No feedbacks available yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>