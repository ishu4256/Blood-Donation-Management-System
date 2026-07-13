<?php
session_start();
$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

if(isset($_POST['next'])){
    $_SESSION['reg_name'] = $conn->real_escape_string($_POST['name']);
    $_SESSION['reg_full_name'] = $conn->real_escape_string($_POST['full_name']);
    $_SESSION['reg_address'] = $conn->real_escape_string($_POST['address']);
    $_SESSION['reg_contact_no'] = $conn->real_escape_string($_POST['contact_no']);
    $_SESSION['reg_email'] = $conn->real_escape_string($_POST['email']);
    $_SESSION['reg_nic'] = $conn->real_escape_string($_POST['nic']);
    $_SESSION['reg_dob'] = $conn->real_escape_string($_POST['dob']);
    $_SESSION['reg_sex'] = $conn->real_escape_string($_POST['sex']);
    $_SESSION['reg_country'] = $conn->real_escape_string($_POST['country']);
    $_SESSION['reg_province'] = $conn->real_escape_string($_POST['province']);
    $_SESSION['reg_district'] = $conn->real_escape_string($_POST['district']);
    $_SESSION['reg_blood_group'] = $conn->real_escape_string($_POST['blood_group']);

    header("Location: New Account2.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Blood Donation Management System</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; background-color:#f2f2f2; margin:0; padding:0; }
        h1 { background-color:red; color:white; font-size:50px; padding:20px; margin:0; text-align:center; }
        h2 { background-color:white; color:black; font-size:40px; text-align:center; margin-top:20px; }
        .form-box { width:700px; margin:auto; background:white; padding:35px; border-radius:10px; box-shadow:0px 0px 10px gray; }
        label { display:inline-block; width:150px; font-size:18px; font-weight:bold; margin-bottom:10px; }
        input, select { width:60%; padding:8px; margin-bottom:10px; font-size:16px; box-sizing: border-box; }
        
       .btn { 
            display: inline-block; 
            width: 160px; 
            height: 48px; 
            line-height: 48px; 
            background-color: red; 
            color: white; 
            border: none; 
            font-size: 20px; 
            cursor: pointer; 
            border-radius: 5px; 
            text-decoration: none; 
            text-align: center;
            box-sizing: border-box; 
            padding: 0; 
        }
        .btn:hover { background-color: darkred; }
        .button-group { text-align: center; margin-top: 25px; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>Create New Account</h2>

    <div class="form-box">
        <form method="POST" action="">
            <label>Name</label>
            <input type="text" name="name" required><br>

            <label>Full Name</label>
            <input type="text" name="full_name" required><br>

            <label>Address</label>
            <input type="text" name="address" required><br>

            <label>Contact No</label>
            <input type="text" name="contact_no" required><br>

            <label>Email</label>
            <input type="email" name="email" required><br>

            <label>NIC</label>
            <input type="text" name="nic" required><br>

            <label>Date of Birth</label>
            <input type="date" name="dob" required><br>

            <label>Sex</label>
            <select name="sex" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>

            <label>Country</label>
            <input type="text" name="country" required><br>

            <label>Province</label>
            <input type="text" name="province" required><br>

            <label>District</label>
            <input type="text" name="district" required><br>

            <label>Blood Group</label>
            <select name="blood_group" required>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select><br><br>

            <div class="button-group">
                <input type="submit" name="next" value="Next" class="btn">
                <a href="login.php" class="btn">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>