<?php
session_start();
$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$error = "";

if(isset($_POST['submit'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    if($password == $confirm_password){
        // Username එක දැනටමත් පද්ධතියේ තිබේදැයි බැලීම
        $checkUser = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($checkUser);

        if($result->num_rows > 0){
            $error = "Username already exists!";
        } else {
            // users table එකට දත්ත ඇතුලත් කිරීම (role එක default ලෙස 'user' ලෙස එක් කර ඇත)
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username','$password', 'user')";

            if($conn->query($sql) === TRUE){
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . $conn->error;
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
        input[type=text], input[type=password] { width:80%; padding:10px; margin:10px; font-size:18px; }
        .btn { padding:12px 30px; background-color:red; color:white; border:none; font-size:20px; cursor:pointer; border-radius:5px; }
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

            <input type="submit" name="submit" value="Submit" class="btn">
        </form>
    </div>

</body>
</html>