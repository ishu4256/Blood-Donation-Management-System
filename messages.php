<?php
session_start();

// Admin කෙනෙක්දැයි පරීක්ෂා කිරීම
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
if($_SESSION['role'] != 'admin'){
    header("Location: Dashboard.php");
    exit();
}

// Database සම්බන්ධතාවය (ඔබේ කේතයේ ඇති නමම භාවිත කර ඇත)
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

// පණිවිඩයක් Read ලෙස සලකුණු කිරීමේ ක්‍රියාවලිය (Update Status)
if(isset($_GET['mark_read_id'])){
    $msg_id = intval($_GET['mark_read_id']);
    $update_query = "UPDATE contact_messages SET status = 'Read' WHERE id = $msg_id";
    if($conn->query($update_query)){
        header("Location: messages.php");
        exit();
    }
}

// සියලුම පණිවිඩ අලුත්ම ඒවා මුලට එන සේ ලබා ගැනීම (Latest First)
$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Messages - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .topbar {
            background: #8e0000;
            color: white;
            padding: 15px;
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
        .table th {
            background-color: #8e0000 !important;
            color: white !important;
        }
        .badge-unread {
            background-color: #dc3545;
            color: white;
        }
        .badge-read {
            background-color: #0d6efd;
            color: white;
        }
        footer {
            background: #8e0000;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Admin Panel</h3>
    <div>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm me-2">Admin Dashboard</a>
        <a href="login.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
</div>

<div class="container mb-5">
    <div class="container-box">
        <h2 class="text-center mb-4">User Contact Messages</h2>
        
        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">
                ← Back to Dashboard
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sender Details</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            // Status එක අනුව වෙනස් පැහැති බැජ් ලබාදීම
                            $status_badge = ($row['status'] == 'Read') ? 'badge-read' : 'badge-unread';
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['full_name']); ?></strong><br>
                            <span class="text-muted small"><?php echo htmlspecialchars($row['email']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td>
                            <p class="mb-0 text-secondary" style="max-width: 300px; word-wrap: break-word;">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </p>
                        </td>
                        <td class="small text-nowrap">
                            <?php echo date('Y-m-d h:i A', strtotime($row['submitted_at'])); ?>
                        </td>
                        <td>
                            <span class="badge <?php echo $status_badge; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if($row['status'] != 'Read') { ?>
                                <a href="messages.php?mark_read_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-success btn-sm px-3 fw-bold" 
                                   title="Mark as Read"
                                   onclick="return confirm('Mark this message as read?')">
                                   ✔ Seen
                                </a>
                            <?php } else { ?>
                                <span class="text-success fw-bold small">Checked</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted py-4'>No messages found in database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    Blood Donation Management System - Admin Dashboard
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>