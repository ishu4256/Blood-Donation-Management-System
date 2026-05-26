<?php

$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

if(isset($_POST['register'])){

    $full_name = $_POST['full_name'];
    $nic = $_POST['nic'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $blood_group = $_POST['blood_group'];
    $weight = $_POST['weight'];
    $last_donation_date = $_POST['last_donation_date'];
    $diseases = $_POST['diseases'];
    $medicines = $_POST['medicines'];
    $availability_status = $_POST['availability_status'];

    // FILE UPLOAD

    $nic_copy = $_FILES['nic_copy']['name'];
    $profile_photo = $_FILES['profile_photo']['name'];

    $nic_tmp = $_FILES['nic_copy']['tmp_name'];
    $photo_tmp = $_FILES['profile_photo']['tmp_name'];

    // CREATE FOLDERS IF NOT EXISTS

    if(!file_exists("uploads/nic")){
        mkdir("uploads/nic",0777,true);
    }

    if(!file_exists("uploads/profile")){
        mkdir("uploads/profile",0777,true);
    }

    move_uploaded_file($nic_tmp, "uploads/nic/".$nic_copy);

    move_uploaded_file($photo_tmp, "uploads/profile/".$profile_photo);

    // INSERT QUERY

    $sql = "INSERT INTO donor(

        full_name,
        nic,
        dob,
        gender,
        phone,
        email,
        address,
        blood_group,
        weight,
        last_donation_date,
        diseases,
        medicines,
        availability_status,
        nic_copy,
        profile_photo

    )

    VALUES(

        '$full_name',
        '$nic',
        '$dob',
        '$gender',
        '$phone',
        '$email',
        '$address',
        '$blood_group',
        '$weight',
        '$last_donation_date',
        '$diseases',
        '$medicines',
        '$availability_status',
        '$nic_copy',
        '$profile_photo'

    )";

    if($conn->query($sql)==TRUE){

        // SUCCESSFULLY INSERTED THEN REDIRECT

        header("Location: donor.php");
        exit();

    }else{

        echo "Error : " . $conn->error;

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Donor Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family: Arial, sans-serif;
}

.card{
    border:none;
    border-radius:20px;
}

.btn-danger{
    padding:12px;
    border-radius:10px;
    font-weight:bold;
}

h2{
    font-weight:bold;
}

label{
    font-weight:600;
}

.form-control,
.form-select{
    border-radius:10px;
}

</style>

</head>
<body>

<div class="container mt-5 mb-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow p-4">

<h2 class="text-center text-danger mb-4">
Register as a Donor
</h2>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>Full Name</label>

<input type="text"
name="full_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>NIC Number</label>

<input type="text"
name="nic"
class="form-control"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>Date of Birth</label>

<input type="date"
name="dob"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Gender</label>

<select name="gender" class="form-select">

<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>

</select>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>Phone Number</label>

<input type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Email Address</label>

<input type="email"
name="email"
class="form-control">

</div>

</div>

<div class="mb-3">

<label>Address</label>

<textarea name="address"
class="form-control"
rows="3"></textarea>

</div>

<div class="row">

<div class="col-md-4 mb-3">

<label>Blood Group</label>

<select name="blood_group"
class="form-select">

<option value="">Select</option>

<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>AB+</option>
<option>AB-</option>
<option>O+</option>
<option>O-</option>

</select>

</div>

<div class="col-md-4 mb-3">

<label>Weight</label>

<input type="number"
name="weight"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Last Donation Date</label>

<input type="date"
name="last_donation_date"
class="form-control">

</div>

</div>

<div class="mb-3">

<label>Diseases</label>

<textarea name="diseases"
class="form-control"
rows="3"></textarea>

</div>

<div class="mb-3">

<label>Medicines</label>

<textarea name="medicines"
class="form-control"
rows="3"></textarea>

</div>

<div class="mb-3">

<label>Availability Status</label>

<select name="availability_status"
class="form-select">

<option value="Available">
Available
</option>

<option value="Unavailable">
Unavailable
</option>

</select>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>NIC Copy</label>

<input type="file"
name="nic_copy"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Profile Photo</label>

<input type="file"
name="profile_photo"
class="form-control">

</div>

</div>

<button type="submit"
name="register"
class="btn btn-danger w-100">
        <a href="donor.php" ></a>

Register as Donor

</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>