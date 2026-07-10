<?php
session_start();
unset($_SESSION['welcome_shown']);

$conn = new mysqli("localhost", "root", "", "blood_donations");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // 💡 මෙහි USERNAME සහ PASSWORD යන දෙකටම BINARY එකතු කර ඇත.
    $sql = "SELECT * FROM users WHERE BINARY username='$username' AND BINARY password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if($row['role'] == 'admin'){
            header("Location: admin_dashboard.php");
            exit();
        }
        else{
            header("Location: Dashboard.php");
            exit();
        }
    }
    else{
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Blood Donation Management System</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; background-color:#f2f2f2; margin:0; padding:0; }
        h1 { background-color: red; color: white; font-size: 50px; padding: 20px; margin:0; text-align:center; }
        h2 { background-color:white; color: black; font-size: 40px; margin-top:20px; text-align:center; }
        .login-box { width:500px; margin:auto; background:white; padding:30px; border-radius:10px; box-shadow:0px 0px 10px gray; text-align:center; }
        label { font-size:20px; font-weight:bold; }
        input[type=text], input[type=password] { width:80%; padding:10px; margin:10px; font-size:18px; }
        .btn { padding:12px 25px; font-size:18px; text-decoration:none; border:none; cursor:pointer; border-radius:5px; }
        .login-btn { background-color:red; color:white; }
        .btn-danger{background-color:red; color:white;}
        .login-btn:hover { background-color:darkred; }
        .link-btn { text-decoration:none; color:blue; font-size:18px; font-family: Arial; }
        .error { color:red; font-size:20px; margin-bottom:15px; }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>LOGIN</h2>

    <div class="login-box">
        <?php if($error != "") { echo "<div class='error'>$error</div>"; } ?>

        <form name="form1" method="post" action="">
            <label>USER NAME</label><br>
            <input type="text" name="username" maxlength="25" required><br><br>

            <label>PASSWORD</label><br>
            <input type="password" name="password" maxlength="25" required><br><br>
            
            <a href="ForgetPassword.php" class="link-btn">Forget Password</a> &nbsp;&nbsp;&nbsp; 
            <a href="New Account1.php" class="link-btn">Create New Account</a>
            <br><br><br>
<pre>
            <input type="submit" value="LOGIN" class="btn login-btn">            <a href="javascript:history.back()" class="btn btn-danger">Exit</a>
</pre>

        </form>
    </div>

</body>
</html>