<?php
session_start();

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$error_msg = "";

if(isset($_POST['done'])){

    $username = $conn->real_escape_string($_POST['username']);
    $phone = $conn->real_escape_string($_POST['phone']);

    // ටේබල් දෙක INNER JOIN එකක් මඟින් එකතු කර පරීක්ෂා කිරීම
    $sql = "SELECT u.*, d.contact_no 
            FROM users u 
            INNER JOIN donor_details d ON u.donor_id = d.donor_id 
            WHERE u.username='$username' AND d.contact_no='$phone'";
            
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){

        $otp = rand(100000, 999999);

        // සෙෂන් එකට දත්ත දමා ගැනීම
        $_SESSION['reset_username'] = $username;
        $_SESSION['otp'] = $otp;

        // 💡 ටෙස්ට් කිරීමට පහසු වීම සඳහා OTP එක Alert එකක් ලෙස පෙන්වා VerifyOTP.php වෙත යයි
        echo "<script>
                alert('Test OTP is: $otp'); 
                window.location.href='VerifyOTP.php';
              </script>";
        exit();

    } else {
        $error_msg = "Invalid Username or Phone Number!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Blood Donation Management System</title>
    <style type="text/css">
        body{ font-family: Arial, sans-serif; background-color:#f2f2f2; margin: 0; }
        h1{ background: red; color: white; font-size: 40px; padding: 20px; margin:0; text-align: center; }
        h2{ color: black; font-size: 30px; margin-top:20px; text-align: center; }
        .login-box{ width:450px; margin:30px auto; background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px gray; }
        label{ font-size:16px; font-weight:bold; display: block; margin-top: 15px; }
        input[type=text]{ width: 100%; padding: 10px; margin-top: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-container { margin-top: 20px; display: flex; justify-content: space-between; }
        .btn{ padding: 10px 25px; font-size: 16px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; text-decoration: none; text-align: center; }
        .btn-submit{ background-color: red; color: white; }
        .btn-cancel{ background-color: #6c757d; color: white; }
        .error{ color: red; font-size: 16px; margin-bottom: 15px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>Forget Password</h2>

    <div class="login-box">
        <?php if(!empty($error_msg)) { echo "<div class='error'>$error_msg</div>"; } ?>

        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Phone Number:</label>
            <input type="text" name="phone" required>

            <div class="btn-container">
                <button type="submit" name="done" class="btn btn-submit">SUBMIT</button> 
                <a href="login.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>