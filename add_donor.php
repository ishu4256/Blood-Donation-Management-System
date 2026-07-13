<?php
session_start();

// adminda login wela inne kiyala balanawa ehema nathi unoth login page ekata yanwa
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}


    // Form eken data ganna eka
if(isset($_POST['save'])){
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $nic = $conn->real_escape_string($_POST['nic']);
    $dob = !empty($_POST['dob']) ? $conn->real_escape_string($_POST['dob']) : NULL;
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $last_donation_date = !empty($_POST['last_donation_date']) ? $conn->real_escape_string($_POST['last_donation_date']) : NULL;
    $diseases = !empty($_POST['diseases']) ? $conn->real_escape_string($_POST['diseases']) : 'no';
    $medicines = !empty($_POST['medicines']) ? $conn->real_escape_string($_POST['medicines']) : 'no';
    
    $province = strtolower(trim($conn->real_escape_string($_POST['province'])));
    $district = strtolower(trim($conn->real_escape_string($_POST['district'])));

    //  Files Upload kirima nic,photo
    $target_dir = "uploads/";
    

    // nic upload
    $nic_copy = "";
    if(!empty($_FILES['nic_copy']['name'])) {
        $nic_filename = time() . "_nic_" . basename($_FILES["nic_copy"]["name"]);
        $nic_target = $target_dir . $nic_filename;
        if(move_uploaded_file($_FILES["nic_copy"]["tmp_name"], $nic_target)) {
            $nic_copy = $nic_filename;
        }
    }


    // profile photo upload
    $profile_photo = "";
    if(!empty($_FILES['profile_photo']['name'])) {
        $profile_filename = time() . "_profile_" . basename($_FILES["profile_photo"]["name"]);
        $profile_target = $target_dir . $profile_filename;
        if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $profile_target)) {
            $profile_photo = $profile_filename;
        }
    }


    // data database ekata add karana sql eka
    $sql = "INSERT INTO donor 
            (full_name, nic, dob, gender, phone, email, address, blood_group, weight, last_donation_date, diseases, medicines, availability_status, Districrt, Province, nic_copy, profile_photo)
            VALUES 
            ('$full_name', '$nic', " . ($dob ? "'$dob'" : "NULL") . ", '$gender', '$phone', '$email', '$address', '$blood_group', $weight, " . ($last_donation_date ? "'$last_donation_date'" : "NULL") . ", '$diseases', '$medicines', 'Available', '$district', '$province', '$nic_copy', '$profile_photo')";

    if($conn->query($sql)){
        header("Location: view_donors.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #31080c; font-family: Arial, sans-serif; }
        .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: none; }
        h2 { color: #dc3545; font-weight: bold; }
        label { font-weight: 600; color: #495057; margin-bottom: 5px; }
    </style>
</head>
<body>


<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card p-4 bg-white">
                
                <h2 class="text-center mb-4">🩸 Register New Blood Donor</h2>
                <hr class="mb-4">

                <!--  data post eken upload kirima -->
                <form method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Ex: Kamal Perera" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIC Number</label>
                            <input type="text" name="nic" class="form-control" placeholder="Ex: 199512345678" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Blood Group</label>
                            <select name="blood_group" class="form-select" required>
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
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Ex: 0771234567" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Ex: kamal@gmail.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>District</label>
                            <select name="district" id="district" class="form-select" required>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Residential Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Enter Full Address..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control" placeholder="Ex: 65.50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Donation Date</label>
                            <input type="date" name="last_donation_date" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Any Medical Diseases?</label>
                            <input type="text" name="diseases" class="form-control" value="no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Taking Any Long-term Medicines?</label>
                            <input type="text" name="medicines" class="form-control" value="no">
                        </div>
                    </div>

                    <div class="row border-top pt-3 mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="text-danger">📄 Upload NIC Copy (Image/PDF)</label>
                            <input type="file" name="nic_copy" class="form-control" accept="image/*,application/pdf">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-danger">📸 Upload Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4 justify-content-end">
                        <a href="view_donors.php" class="btn btn-secondary px-4 fw-bold">Cancel</a>
                        <button type="submit" name="save" class="btn btn-success px-5 fw-bold">Save Donor</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // filter Districts by Province 
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