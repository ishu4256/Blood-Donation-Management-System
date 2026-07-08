<?php
session_start();

// Admin කෙනෙක්දැයි පරීක්ෂා කිරීම (Security)
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$message = "";
$message_class = "";

// 1. URL එකෙන් එන ID එකට අදාළ දැනට පවතින දත්ත කියවීම
if(isset($_GET['id'])) {
    $stock_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM blood_stock WHERE id = ?");
    $stmt->bind_param("i", $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $stock = $result->fetch_assoc();
    } else {
        echo "<script>alert('Record not found!'); window.location.href='blood_stock.php';</script>";
        exit();
    }
} else {
    header("Location: blood_stock.php");
    exit();
}

// 2. Form එක Submit කළ පසු දත්ත යාවත්කාලීන කිරීම (Update Logic)
if(isset($_POST['update_stock'])){
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $units = intval($_POST['units']);
    $collected_date = $conn->real_escape_string($_POST['collected_date']);

    // ඔබේ database එකේ තීරු වල නම් (name, blood_group, units, collected_date) ලෙස සකසා ඇත
    $update_stmt = $conn->prepare("UPDATE blood_stock SET name = ?, blood_group = ?, units = ?, collected_date = ? WHERE id = ?");
    $update_stmt->bind_param("ssisi", $hospital_name, $blood_group, $units, $collected_date, $stock_id);
    
    if($update_stmt->execute()){
        // සාර්ථකව අප්ඩේට් වූ පසු පණිවිඩයක් සමඟ නැවත ලැයිස්තුවට යොමු කෙරේ
        // (සටහන: ඔබේ ලැයිස්තු පිටුවේ නම වෙනස් නම් 'blood_stock.php' වෙනුවට එය යොදන්න)
        echo "<script>alert('🎉 Blood stock updated successfully!'); window.location.href='blood_stock.php';</script>";
        exit();
    } else {
        $message = "❌ Error updating stock: " . $conn->error;
        $message_class = "alert-danger";
    }
}

// Dropdown එක සඳහා රෝහල් ලැයිස්තුව ලබා ගැනීම
$hospitals_result = $conn->query("SELECT name FROM hospitals ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blood Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 550px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px #ccc;
            margin: 50px auto;
        }
        .btn-custom {
            background-color: #8e0000;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #6f0000;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h3 class="text-center mb-4" style="color: #8e0000; font-weight: bold;">✏️ Edit Blood Stock Entry</h3>
        
        <?php if(!empty($message)): ?>
            <div class="alert <?php echo $message_class; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            
            <div class="mb-3">
                <label class="form-label fw-bold small">Hospital / Location</label>
                <select name="hospital_name" class="form-select" required>
                    <option value="">-- Select Hospital --</option>
                    <?php 
                    if($hospitals_result && $hospitals_result->num_rows > 0){
                        while($h_row = $hospitals_result->fetch_assoc()){
                            // දැනට ඩේටාබේස් එකේ ඇති රෝහල auto-selected කිරීමට
                            $selected = ($h_row['name'] == $stock['name']) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($h_row['name'])."' $selected>".htmlspecialchars($h_row['name'])."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Blood Group</label>
                <select name="blood_group" class="form-select" required>
                    <option value="A+" <?php echo $stock['blood_group'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo $stock['blood_group'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo $stock['blood_group'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo $stock['blood_group'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                    <option value="O+"> <?php echo $stock['blood_group'] == 'O+' ? 'selected' : ''; ?>O+</option>
                    <option value="O-" <?php echo $stock['blood_group'] == 'O-' ? 'selected' : ''; ?>>O-</option>
                    <option value="AB+" <?php echo $stock['blood_group'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo $stock['blood_group'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Units (බෑග් ගණන)</label>
                <input type="number" name="units" class="form-control" min="0" value="<?php echo htmlspecialchars($stock['units']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Collected Date (ලබාගත් දිනය)</label>
                <input type="date" name="collected_date" class="form-control" value="<?php echo htmlspecialchars($stock['collected_date']); ?>" required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" name="update_stock" class="btn btn-custom fw-bold">💾 Save & Update Stock</button>
                <a href="javascript:history.back()" class="btn btn-secondary fw-bold">Cancel</a>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>