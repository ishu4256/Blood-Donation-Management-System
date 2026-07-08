<?php
session_start();
// ආරක්ෂාව සඳහා Admin ද යන්න පරීක්ෂා කිරීම
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

if(isset($_POST['save'])){
    // Form එකෙන් එන දත්ත ආරක්ෂිතව ලබා ගැනීම (SQL Injection වැළැක්වීමට real_escape_string භාවිත කර ඇත)
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
    
    // සෙවුම් පද්ධතියේ පහසුව සඳහා පළාත සහ දිස්ත්‍රික්කය සිම්පල් අකුරෙන්ම (lowercase) සුරැකීම
    $province = strtolower(trim($conn->real_escape_string($_POST['province'])));
    $district = strtolower(trim($conn->real_escape_string($_POST['district'])));

    // 💡 සියලුම තීරු ඇතුළත් කර සකස් කළ INSERT Query එක (ඩේටාබේස් එකේ ඇති 'Districrt' අක්ෂර වින්‍යාසය අනුවම සකසා ඇත)
    $sql = "INSERT INTO donor 
            (full_name, nic, dob, gender, phone, email, address, blood_group, weight, last_donation_date, diseases, medicines, availability_status, Districrt, Province)
            VALUES 
            ('$full_name', '$nic', " . ($dob ? "'$dob'" : "NULL") . ", '$gender', '$phone', '$email', '$address', '$blood_group', $weight, " . ($last_donation_date ? "'$last_donation_date'" : "NULL") . ", '$diseases', '$medicines', 'Available', '$district', '$province')";

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
    <title>Add Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
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

                <form method="post">
                    
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
                            <select name="province" class="form-select" required>
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
                            <input type="text" name="district" class="form-control" placeholder="Ex: Colombo / Matara" required>
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
                            <input type="text" name="diseases" class="form-control" placeholder="Ex: None / Diabetes" value="no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Taking Any Long-term Medicines?</label>
                            <input type="text" name="medicines" class="form-control" placeholder="Ex: None / Metformin" value="no">
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

</body>
</html>