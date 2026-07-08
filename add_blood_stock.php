<?php
// session එක පරීක්ෂා කිරීම
session_start();
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

// Form එක Submit කළ පසු ක්‍රියාත්මක වන කොටස
if(isset($_POST['submit_stock'])){
    // Form එකෙන් දත්ත ලබා ගැනීම
    $hospital_name = $_POST['hospital_name']; // මෙතනට එන්නේ dropdown එකෙන් තෝරන රෝහලේ නම
    $blood_group = $_POST['blood_group'];
    $units = intval($_POST['units']);

    if(!empty($hospital_name) && !empty($blood_group) && $units >= 0){
        
        /* 💡 ON DUPLICATE KEY UPDATE:
          blood_stock ටේබල් එකේ 'name' සහ 'blood_group' කියන දෙක එකතු වෙලා UNIQUE INDEX එකක් තියෙනවා නම්,
          දැනටමත් තියෙන රෝහලක ලේ තොගය අලුතින් ඇතුලත් නොකර පවතින තොගයට එකතු (UPDATE) කරනු ලබයි.
          නැතහොත් අලුත් පේළියක් (INSERT) සාදයි.
        */
        $stmt = $conn->prepare("INSERT INTO blood_stock (blood_group, units, name) VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE units = units + ?");
        $stmt->bind_param("sisi", $blood_group, $units, $hospital_name, $units);
        
        if($stmt->execute()){
            $message = "Blood stock successfully added/updated!";
            $message_class = "alert-success";
        } else {
            $message = "Error: Something went wrong. " . $conn->error;
            $message_class = "alert-danger";
        }
    } else {
        $message = "Please enter valid information.";
        $message_class = "alert-warning";
    }
}

// Dropdown එක සඳහා රෝහල් ලැයිස්තුව ඩේටාබේස් එකෙන් ලබා ගැනීම
$hospitals_result = $conn->query("SELECT name FROM hospitals ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blood Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: Arial;
        }
        .form-container {
            max-width: 500px;
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
        <h3 class="text-center mb-4" style="color: #8e0000; font-weight: bold;">Add Blood Stock to Hospital</h3>
        
        <?php if(!empty($message)): ?>
            <div class="alert <?php echo $message_class; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="add_blood_stock.php">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Select Hospital</label>
                <select name="hospital_name" class="form-control" required>
                    <option value="">-- Select Hospital --</option>
                    <?php 
                    if($hospitals_result && $hospitals_result->num_rows > 0){
                        while($row = $hospitals_result->fetch_assoc()){
                            echo "<option value='".htmlspecialchars($row['name'])."'>".htmlspecialchars($row['name'])."</option>";
                        }
                    } else {
                        echo "<option value=''>No hospitals found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Blood Group</label>
                <select name="blood_group" class="form-control" required>
                    <option value="">-- Select Blood Group --</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Number of Units (Bags)</label>
                <input type="number" name="units" class="form-control" placeholder="e.g. 10" min="1" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="submit_stock" class="btn btn-custom">Add Stock</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>