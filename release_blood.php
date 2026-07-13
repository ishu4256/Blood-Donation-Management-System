<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { die("Connection Failed : " . $conn->connect_error); }

$msg = "";

$location_query = $conn->query("SELECT DISTINCT name FROM blood_stock ORDER BY name ASC");

if (isset($_POST['blood_releases'])) {
    $id = isset($_POST['stock_id']) ? intval($_POST['stock_id']) : 0;
    $bags_to_release = intval($_POST['units']);

    if ($id > 0 && $bags_to_release > 0) {
        
        // slected Record eke thiyana thoga saha visthara balana eka
        $check_stock = $conn->query("SELECT units, blood_group, name FROM blood_stock WHERE id = $id");
        $stock_row = $check_stock->fetch_assoc();
        
        if ($stock_row) {
            $current_units = intval($stock_row['units']);
            $blood_group = $stock_row['blood_group'];
            $name = $stock_row['name'];

            // illana ganata wada stock ek thiyada balana ek
            if ($current_units >= $bags_to_release) {
                
                // 🛑 DATABASE TRANSACTION START
                $conn->begin_transaction();

                try {
                    // (UPDATE Query)
                    $sql_update = "UPDATE blood_stock SET units = units - $bags_to_release WHERE id = $id";
                    $conn->query($sql_update);

                   
                    
                $stmt = $conn->prepare("INSERT INTO blood_releases (booking_id, patient_name, hospital_name, blood_group, units, address) VALUES (0, 'Admin Released', ?, ?, ?, 'Direct Release')");
$stmt->bind_param("ssi", $name, $blood_group, $bags_to_release);
                    $stmt->execute();

                    $conn->commit(); // data confirm karanna
                    $msg = "<div class='alert alert-success fw-bold'>🎉 Successfully released $bags_to_release Units of $blood_group from $name! Stock updated automatically.</div>";
                    
                } catch (Exception $e) {
                    $conn->rollback(); // wenaskam awalangu karanna
                    $msg = "<div class='alert alert-danger'>❌ Error updating stock: " . $e->getMessage() . "</div>";
                }

            } else {
                $msg = "<div class='alert alert-danger fw-bold'>⚠️ Insufficient Stock! Only ($current_units) units available for $blood_group at $name.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Selected stock item not found.</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please enter valid information.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Release Blood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .release-card { max-width: 650px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        .form-label { font-weight: bold; color: #333; }
        .btn-custom { background-color: #8e0000; color: white; font-weight: bold; }
        .btn-custom:hover { background-color: #c0392b; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="release-card">
        <h2 class="text-center mb-3" style="color: #8e0000; font-weight: bold;">🩸 Blood Release Form</h2>
        <p class="text-muted text-center">Select the specific location and blood group to decrease stock automatically.</p>
        <hr>

        <?php echo $msg; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="form-label">Select Blood Stock Source (Location & Group)</label>
                <select name="stock_id" class="form-select form-select-lg" required id="stock_select">
                    <option value="">-- Select Available Stock Item --</option>
                    <?php 
                    $stock_list = $conn->query("SELECT * FROM blood_stock WHERE units > 0 ORDER BY name ASC");
                    while($st = $stock_list->fetch_assoc()) {
                        echo "<option value='{$st['id']}'>{$st['name']} -> [ Group: {$st['blood_group']} | Available: {$st['units']} Units ]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Quantity to Release (Units)</label>
                <input type="number" name="units" class="form-control form-control-lg" min="1" placeholder="Enter number of units" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="blood_stock.php" class="btn btn-secondary px-4">Back to Stock</a>
                <button type="submit" name="blood_releases" class="btn btn-custom px-5">Release & Update</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>