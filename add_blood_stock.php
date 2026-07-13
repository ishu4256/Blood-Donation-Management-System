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
    $district = $_POST['district']; 
    $hospital_name = $_POST['hospital_name']; 
    $blood_group = strtoupper($_POST['blood_group']); // Capital O/A/B කිරීමට
    $units = intval($_POST['units']);

    if(!empty($district) && !empty($hospital_name) && !empty($blood_group) && $units > 0){
        
        $stmt = $conn->prepare("INSERT INTO blood_stock (name, district, blood_group, units, collected_date) 
                                VALUES (?, ?, ?, ?, CURDATE()) 
                                ON DUPLICATE KEY UPDATE units = units + ?");
        
        $stmt->bind_param("sssii", $hospital_name, $district, $blood_group, $units, $units);
        
        if($stmt->execute()){
            $message = "Blood stock successfully added/updated!";
            $message_class = "alert-success";
        } else {
            $message = "Error: " . $conn->error;
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