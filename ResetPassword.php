<?php
session_start();

// OTP එක වෙරිෆයි නොකර කෙලින්ම ආවොත් හරවා යැවීම
if(!isset($_SESSION['otp_verified']) || !isset($_SESSION['reset_username'])){
    header("Location: ForgetPassword.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
$error_msg = "";

if(isset($_POST['reset'])){
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $username = $_SESSION['reset_username'];

    if($new_pass === $confirm_pass){
        // ⚠️ සටහන: ඔයා ඩේටාබේස් එකේ password ප්ලේන් ටෙක්ස්ට් (1234) විදිහටම සේව් කරන නිසා මෙලෙස දැම්මා. 
        // ආරක්ෂාව සඳහා $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT); භාවිතා කිරීම වඩා සුදුසුයි.
        $escaped_pass = $conn->real_escape_string($new_pass);

        // users ටේබල් එකේ password එක වෙනස් කිරීමේ SQL Query එක
        $sql = "UPDATE users SET password='$escaped_pass' WHERE username='$username'";

        if($conn->query($sql)){
            // සෙෂන්ස් සියල්ල ඉවත් කිරීම
            session_destroy();
            echo "<script>
                    alert('🎉 Password Reset Successfully! Please login with your new password.'); 
                    window.location.href='login.php';
                  </script>";
            exit();
        } else {
            $error_msg = "Error updating password in database.";
        }
    } else {
        $error_msg = "Passwords do not match! Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style type="text/css">
        body{ font-family: Arial, sans-serif; background-color:#f2f2f2; margin: 0; }
        h1{ background: red; color: white; font-size: 40px; padding: 20px; margin:0; text-align: center; }
        h2{ color: black; font-size: 30px; margin-top:20px; text-align: center; }
        .login-box{ width:450px; margin:30px auto; background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px gray; }
        label{ font-size:16px; font-weight:bold; display: block; margin-top: 15px; }
        input[type=password]{ width: 100%; padding: 10px; margin-top: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-container { margin-top: 20px; display: flex; justify-content: space-between; }
        .btn{ padding: 10px 25px; font-size: 16px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; text-decoration: none; text-align: center; width: 100%; }
        .btn-submit{ background-color: red; color: white; }
        .error{ color: red; font-size: 16px; margin-bottom: 15px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>Create New Password</h2>

    <div class="login-box">
        <?php if(!empty($error_msg)) { echo "<div class='error'>$error_msg</div>"; } ?>

        <form method="POST" action="">
            <label>New Password:</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password" required>

            <div class="btn-container">
                <button type="submit" name="reset" class="btn btn-submit">RESET PASSWORD</button> 
            </div>
        </form>
    </div>

</body>
</html>