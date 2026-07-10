<?php

$conn = new mysqli("localhost","root","","blood_donations");

if(isset($_POST['save'])){

$name = $_POST['name'];
$location = $_POST['location'];
$contact = $_POST['contact'];
 $province = strtolower(trim($conn->real_escape_string($_POST['province'])));
    $district = strtolower(trim($conn->real_escape_string($_POST['district'])));

$conn->query("INSERT INTO hospitals(name,location,contact,province,district)
VALUES('$name','$location','$contact','$province','$district')");

header("Location:view_hospitals.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Hospital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
        body { background: #31080c; font-family: Arial, sans-serif; }
        .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: none; }
        h2 { color: #dc3545; font-weight: bold; }
        label { font-weight: 600; color: #495057; margin-bottom: 5px; }
    </style>
</head>
<body>

<div class="container mt-5">

<div class="card p-4">

<h2>Add Hospital</h2>

<form method="post">

<input type="text" name="name"
class="form-control mb-3"
placeholder="Hospital Name" required>

<input type="text" name="location"
class="form-control mb-3"
placeholder="Location" required>

<input type="text" name="contact"
class="form-control mb-3"
placeholder="Contact Number" required>


<label>Province</label>
                            <select name="province" id="province" class="form-select" required onchange="updateDistricts()">
                                <option value="">Select Province</option>
                                <option value="Western">Western Province</option>
                                <option value="Southern">Southern Province</option>
                                <option value="Central">Central Province</option>
                                <option value="Northern">Northern Province</option>
                                <option value="Eastern">Eastern Province</option>
                                <option value="North Western">North Western Province</option>
                                <option value="North Central">North Central Province</option>
                                <option value="Uva">Uva Province</option>
                                <option value="Sabaragamuwa">Sabaragamuwa Province</option>
                            </select>
<br>
<label>District</label>
                            <select name="district" id="district" class="form-select" required>
                                <option value="">Select District</option>
                            </select>



<button name="save"
class="btn btn-success">
Save Hospital
</button>

</form>

</div>

</div>
<script>
const districtsByProvince = {
    "Western": ["Colombo", "Gampaha", "Kalutara"],
    "Southern": ["Galle", "Matara", "Hambantota"],
    "Central": ["Kandy", "Matale", "Nuwara Eliya"],
    "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu"],
    "Eastern": ["Trincomalee", "Batticaloa", "Ampara"],
    "North Western": ["Kurunegala", "Puttalam"],
    "North Central": ["Anuradhapura", "Polonnaruwa"],
    "Uva": ["Badulla", "Monaragala"],
    "Sabaragamuwa": ["Ratnapura", "Kegalle"]
};

function updateDistricts() {
    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");
    const selectedProvince = provinceSelect.value;

    districtSelect.innerHTML = '<option value="">Select District</option>';

    if (selectedProvince && districtsByProvince[selectedProvince]) {
        districtsByProvince[selectedProvince].forEach(district => {
            const option = document.createElement("option");
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
}
</script>
</body>
</html>