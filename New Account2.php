<?php
session_start();
$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$error = "";

// පළමු පියවර සම්පූර්ණ කර නැත්නම් ආපසු හැරවීම
if (!isset($_SESSION['reg_name'])) {
    header("Location: New Account1.php");
    exit();
}

if(isset($_POST['submit'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    if($password == $confirm_password){
        // Username එක දැනටමත් තියෙනවද බැලීම
        $checkUser = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($checkUser);

        if($result->num_rows > 0){
            $error = "Username already exists!";
        } else {
            
            // Session එකෙන් පළමු පිටුවේ දත්ත ලබා ගැනීම
            $name = $_SESSION['reg_name'];
            $full_name = $_SESSION['reg_full_name'];
            $address = $_SESSION['reg_address'];
            $contact_no = $_SESSION['reg_contact_no'];
            $email = $_SESSION['reg_email'];
            $nic = $_SESSION['reg_nic'];
            $dob = $_SESSION['reg_dob'];
            $sex = $_SESSION['reg_sex'];
            $country = $_SESSION['reg_country'];
            $province = $_SESSION['reg_province'];
            $district = $_SESSION['reg_district'];
            $blood_group = $_SESSION['reg_blood_group'];

            // 1. මුලින්ම donor_details එකට දත්ත දැමීම
            $sql_details = "INSERT INTO donor_details 
                    (name, full_name, address, contact_no, email, nic, date_of_birth, sex, country, province, district, blood_group) 
                    VALUES 
                    ('$name','$full_name','$address','$contact_no','$email','$nic','$dob','$sex','$country','$province','$district','$blood_group')";

            if($conn->query($sql_details) === TRUE){
                
                // 💡 2. ස්වයංක්‍රීයව හැදුණු අලුත්ම ID එක ලබා ගැනීම
                $new_donor_id = $conn->insert_id;

                // 3. එම ලබාගත් ID එකම යොදාගෙන users ටේබල් එකට දත්ත දැමීම
                $sql_users = "INSERT INTO users (donor_id, username, password, role) VALUES ($new_donor_id, '$username', '$password', 'user')";

                if($conn->query($sql_users) === TRUE){
                    // වැඩේ සාර්ථකයි නම් Session දත්ත මකා දැමීම
                    session_unset();
                    session_destroy();
                    
                    echo "<script>alert('ගිණුම සාර්ථකව සාදන ලදී!'); window.location.href='login.php';</script>";
                    exit();
                } else {
                    $error = "Users ටේබල් එකට දත්ත දැමීමේදී දෝෂයක්: " . $conn->error;
                }
            } else {
                $error = "Donor Details ටේබල් එකට දත්ත දැමීමේදී දෝෂයක්: " . $conn->error;
            }
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Blood Donation Management System</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; background-color:#f2f2f2; margin:0; padding:0; }
        h1 { background-color:red; color:white; font-size:50px; padding:20px; margin:0; text-align:center; }
        h2 { background-color:white; color:black; font-size:40px; margin-top:20px; text-align:center; }
        .form-box { width:600px; margin:auto; background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px gray; text-align:center; }
        label { font-size:20px; font-weight:bold; }
        input[type=text], input[type=password] { width:80%; padding:10px; margin:10px; font-size:18px; box-sizing: border-box; }
        
        .btn { 
            display: inline-block; 
            padding: 12px 0px; 
            min-width: 140px;  
            background-color: red; 
            color: white; 
            border: none; 
            font-size: 20px; 
            cursor: pointer; 
            border-radius: 5px; 
            text-decoration: none; 
            text-align: center;
            box-sizing: border-box; 
            vertical-align: middle;
        }
        .btn:hover { background-color:darkred; }
        .error { color:red; font-size:18px; margin-bottom:15px; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>Create Login Account</h2>

    <div class="form-box">
        <?php if($error != ""){ echo "<div class='error'>$error</div>"; } ?>

        <form method="POST" action="">
            <label>USER NAME</label><br>
            <input type="text" name="username" maxlength="25" required><br><br>

            <label>PASSWORD</label><br>
            <input type="password" name="password" maxlength="25" required><br><br>

            <label>CONFIRM PASSWORD</label><br>
            <input type="password" name="confirm_password" maxlength="25" required><br><br><br>

            <div style="text-align: center; gap: 15px; display: flex; justify-content: center; align-items: center;">
                <input type="submit" name="submit" value="Submit" class="btn">
                <a href="New Account1.php" class="btn">Back</a>
            </div>

        </form>
    </div>

</body>
</html>