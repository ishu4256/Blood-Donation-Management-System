<?php
session_start();
//role ek adminda kiyala balana eka 
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}


//connection eka
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}


// hospital list eka district ekata anuwa ganna eka
if(isset($_GET['get_hospitals_by_district'])) {
    $district = $conn->real_escape_string($_GET['get_hospitals_by_district']);
    $query = "SELECT name FROM hospitals WHERE district = '$district' ORDER BY name ASC";
    $result = $conn->query($query);
    
    $hospitals = [];
    if($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $hospitals[] = $row['name'];
        }
    }
    header('Content-Type: application/json');
    echo json_encode($hospitals);
    exit();
}

$message = "";
$message_class = "";


//blood stock add karana eka
if(isset($_POST['submit_stock'])){
    $district = $conn->real_escape_string($_POST['district']);
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $units_by_group = isset($_POST['units']) && is_array($_POST['units']) ? $_POST['units'] : [];
    $added_groups = 0;

    if(!empty($district) && !empty($hospital_name)){
        $conn->begin_transaction();
        try {
            foreach($units_by_group as $blood_group => $group_units){
                $blood_group = strtoupper($conn->real_escape_string($blood_group));
                $units = intval($group_units);

                if($units <= 0){
                    continue;
                }

                $stock_res = $conn->query("SELECT id FROM blood_stock WHERE district = '$district' AND name = '$hospital_name' AND blood_group = '$blood_group' AND collected_date = CURDATE() LIMIT 1");

                if($stock_res && $stock_res->num_rows > 0){
                    $stock_row = $stock_res->fetch_assoc();
                    $stock_id = intval($stock_row['id']);
                    $query_success = $conn->query("UPDATE blood_stock SET units = units + $units WHERE id = $stock_id");
                } else {
                    $query_success = $conn->query("INSERT INTO blood_stock (name, district, blood_group, units, collected_date) VALUES ('$hospital_name', '$district', '$blood_group', $units, CURDATE())");
                }

                if(!$query_success){
                    throw new Exception($conn->error);
                }

                $added_groups++;
            }

            if($added_groups === 0){
                throw new Exception('Enter units for at least one blood group.');
            }

            $conn->commit();
            $message = "Blood stock successfully added/updated for $added_groups blood group(s)!";
            $message_class = "alert-success";
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
            $message_class = "alert-danger";
        }
    } else {
        $message = "Please enter valid information.";
        $message_class = "alert-warning";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Blood Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #31080c; font-family: Arial; }
        .form-container { max-width: 500px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 15px #ccc; margin: 50px auto; }
        .btn-custom { background-color: #8e0000; color: white; border: none; }
        .btn-custom:hover { background-color: #6f0000; color: white; }
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
                <label class="form-label fw-bold">District</label>
                <select name="district" id="districtSelect" class="form-control" required>
                    <option value="">-- Select District --</option>
                    <?php
                    $districts = ["Colombo", "Gampaha", "Kalutara", "Kandy", "Matale", "Nuwara Eliya", "Galle", "Matara", "Hambantota", "Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu", "Batticaloa", "Ampara", "Trincomalee", "Kurunegala", "Puttalam", "Anuradhapura", "Polonnaruwa", "Badulla", "Monaragala", "Ratnapura", "Kegalle"];
                    foreach($districts as $dist) { echo "<option value='$dist'>$dist</option>"; }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Select Hospital</label>
                <select name="hospital_name" id="hospitalSelect" class="form-control" required>
                    <option value="">-- Select District First --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Units by Blood Group (Bags)</label>
                <div class="row g-2">
                    <?php foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood_group): ?>
                        <div class="col-6">
                            <label class="form-label small mb-1"><?php echo $blood_group; ?></label>
                            <input type="number" name="units[<?php echo $blood_group; ?>]" class="form-control" min="0" placeholder="0">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-text">Enter quantities for one or more groups. Empty fields are ignored.</div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="submit_stock" class="btn btn-custom">Add Stock</button>
                <a href="blood_stock.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<script>
    
    //select district ekata anuwa hospital list eka ganna eka
document.getElementById('districtSelect').addEventListener('change', function() {
    var district = this.value;
    var hospitalSelect = document.getElementById('hospitalSelect');
    hospitalSelect.innerHTML = '<option value="">-- Loading Hospitals... --</option>';
    
    if(district === '') {
        hospitalSelect.innerHTML = '<option value="">-- Select District First --</option>';
        return;
    }
    
    fetch('add_blood_stock.php?get_hospitals_by_district=' + encodeURIComponent(district))
        .then(response => response.json())
        .then(data => {
            hospitalSelect.innerHTML = '<option value="">-- Select Hospital --</option>';
            if(data.length > 0) {
                data.forEach(function(hospital) {
                    var option = document.createElement('option');
                    option.value = hospital;
                    option.textContent = hospital;
                    hospitalSelect.appendChild(option);
                });
            } else {
                hospitalSelect.innerHTML = '<option value="">No hospitals found in this district</option>';
            }
        });
});
</script>
</body>
</html>