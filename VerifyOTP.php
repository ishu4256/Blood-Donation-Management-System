<?php
session_start();

// ForgetPassword පිටුවෙන් නොවී කෙලින්ම ආවොත් හරවා යැවීම
if(!isset($_SESSION['otp']) || !isset($_SESSION['reset_username'])){
    header("Location: ForgetPassword.php");
    exit();
}

$error_msg = "";

if(isset($_POST['verify'])){
    $user_otp = trim($_POST['otp']);

    // Session එකේ තියෙන OTP එකත් එක්ක පරිශීලකයා ගැහුව OTP එක සමානද බැලීම
    if($user_otp == $_SESSION['otp']){
        $_SESSION['otp_verified'] = true; // ඊළඟ පිටුවට යන්න අවසර දීම
        header("Location: ResetPassword.php");
        exit();
    } else {
        $error_msg = "Invalid OTP Number! Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style type="text/css">
        body{ font-family: Arial, sans-serif; background-color:#f2f2f2; margin: 0; }
        h1{ background: red; color: white; font-size: 40px; padding: 20px; margin:0; text-align: center; }
        h2{ color: black; font-size: 30px; margin-top:20px; text-align: center; }
        .login-box{ width:450px; margin:30px auto; background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px gray; }
        label{ font-size:16px; font-weight:bold; display: block; margin-top: 15px; }
        input[type=text]{ width: 100%; padding: 10px; margin-top: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; text-align:center; font-weight:bold; letter-spacing: 5px; }
        .btn-container { margin-top: 20px; display: flex; justify-content: space-between; }
        .btn{ padding: 10px 25px; font-size: 16px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; text-decoration: none; text-align: center; width: 48%; }
        .btn-submit{ background-color: red; color: white; }
        .btn-cancel{ background-color: #6c757d; color: white; }
        .error{ color: red; font-size: 16px; margin-bottom: 15px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>Enter OTP Code</h2>

    <div class="login-box">
        <p style="text-align:center; color:#555;">We have sent a 6-digit verification code to your phone number.</p>
        
        <?php if(!empty($error_msg)) { echo "<div class='error'>$error_msg</div>"; } ?>

        <form method="POST" action="">
            <label style="text-align:center;">Enter 6-Digit OTP:</label>
            <input type="text" name="otp" maxlength="6" placeholder="******" required>

            <div class="btn-container">
                <button type="submit" name="verify" class="btn btn-submit">VERIFY</button> 
                <a href="ForgetPassword.php" class="btn btn-cancel">Back</a>
            </div>
        </form>
    </div>

</body>
</html>