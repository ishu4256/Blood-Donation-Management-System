<?php
session_start();
// මෙතනදී Admin කෙනෙක්ද කියලා පරීක්ෂා කරගන්න 
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') { ... }

$conn = new mysqli("localhost", "root", "", "blood_donations");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// 1. Action: "Mark as Seen" බොත්තම ක්ලික් කළ විට Status එක යාවත්කාලීන කිරීම
if (isset($_POST['mark_seen'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $update_sql = "UPDATE feedback SET status = 'Seen' WHERE id = $feedback_id";
    $conn->query($update_sql);
    
    // පිටුව නැවත Load කිරීම (Refresh)
    header("Location: " . $_SERVER['PHP_SELF'] . (isset($_GET['filter']) ? "?filter=" . $_GET['filter'] : ""));
    exit();
}

// 2. Filter: Dropdown එකෙන් තෝරන ආකාරයට දත්ත පෙරීම
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Unseen'; // Default පෙන්වන්නේ නොකියවූ ඒවා

if ($filter == 'All') {
    $sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
} elseif ($filter == 'Seen') {
    $sql = "SELECT * FROM feedback WHERE status = 'Seen' ORDER BY submitted_at DESC";
} else {
    // Unseen පණිවිඩ සඳහා
    $sql = "SELECT * FROM feedback WHERE status = 'Unseen' OR status IS NULL ORDER BY submitted_at DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - User Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #31080c; font-family: Arial, sans-serif; }
        .admin-container { max-width: 1000px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .table-header { background-color: #8e0000; color: white; }
        .badge-seen { background-color: #27ae60; }
        .badge-unseen { background-color: #e67e22; }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <a href="admin_dashboard.php" class="btn btn-secondary shadow-sm">Back to Dashboard</a>
</div>

<div class="container">
    <div class="admin-container">
        <h2 class="mb-4 text-center" style="color: #8e0000; font-weight: bold;">User Feedbacks & Suggestions</h2>
        <hr>
        
        <!-- 🔍 Filter Selector Box -->
        <div class="row my-4 justify-content-end">
            <div class="col-md-5">
                <form method="GET" action="" class="d-flex align-items-center">
                    <label for="filter" class="me-2 fw-bold text-secondary text-nowrap">Filter Messages:</label>
                    <select name="filter" id="filter" class="form-select me-2" onchange="this.form.submit()">
                        <option value="Unseen" <?php if($filter == 'Unseen') echo 'selected'; ?>>New / Unseen Messages</option>
                        <option value="Seen" <?php if($filter == 'Seen') echo 'selected'; ?>>Read / Seen Messages</option>
                        <option value="All" <?php if($filter == 'All') echo 'selected'; ?>>All Messages</option>
                    </select>
                </form>
            </div>
        </div>
        
        <!-- 📋 Feedback Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-header text-center">
                    <tr>
                        <th style="width: 8%;">ID</th>
                        <th style="width: 20%;">Username</th>
                        <th style="width: 40%;">Feedback Message</th>
                        <th style="width: 17%;">Submitted Date</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $date = date("Y-M-d - h:i A", strtotime($row['submitted_at']));
                            // Status එක අනුව පාට වෙනස් බෝගයක් (Badge) පෙන්වීම
                            $status = (isset($row['status']) && $row['status'] == 'Seen') ? 'Seen' : 'Unseen';
                            
                            echo "<tr>";
                            echo "<td class='text-center fw-bold'>" . $row['id'] . "</td>";
                            echo "<td>
                                    <span class='fw-bold text-secondary'>" . htmlspecialchars($row['username']) . "</span><br>";
                                    if ($filter == 'All') {
                                        $badgeClass = ($status == 'Seen') ? 'badge-seen' : 'badge-unseen';
                                        echo "<span class='badge $badgeClass'>$status</span>";
                                    }
                            echo "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                            echo "<td class='text-center text-muted small'>" . $date . "</td>";
                            echo "<td class='text-center'>";
                            
                            // පණිවිඩය තවමත් කියවා නැත්නම් පමණක් "Mark as Seen" බොත්තම පෙන්වයි
                            if ($status == 'Unseen') {
                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='feedback_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='mark_seen' class='btn btn-success btn-sm px-3 shadow-sm'>Mark as Seen</button>";
                                echo "</form>";
                            } else {
                                echo "<span class='text-success fw-bold small'>✔️ Read</span>";
                            }
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No feedbacks available under this category.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>