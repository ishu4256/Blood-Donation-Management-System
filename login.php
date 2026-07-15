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
        body { 
            font-family: Arial, sans-serif; 
            margin:0; 
            padding:0;
            background-image: url('images/bbb.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }
        
        /* Heading එක photo එක වහන්නේ නැති වෙන්න transparent කළා */
        h1 { 
            background-color: rgba(255, 0, 0, 0.75); 
            color: white; 
            font-size: 38px; 
            padding: 15px; 
            margin:0; 
            text-align:center;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        h2 { 
            color: white; 
            font-size: 32px; 
            margin-top: 30px; 
            margin-bottom: 10px;
            text-align:center; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            font-weight: bold;
            letter-spacing: 2px;
        }
        
        /* මැද තියෙන ලේ බින්දුව පේන්න box එක විනිවිද පෙනෙන විදිහට හැදුවා */
        .login-box { 
            width: 450px; 
            margin: 20px auto; 
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 35px 25px; 
            border-radius: 15px; 
            box-shadow: 0px 15px 25px rgba(0,0,0,0.6); 
            text-align: center; 
        }
        
        label { 
            font-size: 16px; 
            font-weight: bold; 
            color: #fff;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        /* Input fields කළු පසුබිමට ගැලපෙන ලෙස වෙනස් කළා */
        input[type=text], input[type=password] { 
            width: 85%; 
            padding: 12px; 
            margin: 10px 0; 
            font-size: 16px; 
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: 0.3s;
        }
        
        input[type=text]:focus, input[type=password]:focus {
            border-color: #ff4d4d;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 8px rgba(255, 77, 77, 0.6);
        }
        
        .btn { 
            padding: 12px 30px; 
            font-size: 16px; 
            font-weight: bold;
            text-decoration: none; 
            border: none; 
            cursor: pointer; 
            border-radius: 6px; 
            transition: 0.3s;
            display: inline-block;
        }
        
        .login-btn { 
            background-color: #ff0000; 
            color: white; 
            box-shadow: 0 4px 10px rgba(255,0,0,0.3);
        }
        
        .login-btn:hover { 
            background-color: #cc0000; 
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background-color: rgba(255, 255, 255, 0.15); 
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            margin-left: 10px;
        }
        
        .btn-danger:hover {
            background-color: rgba(255, 0, 0, 0.4);
            border-color: #ff0000;
            transform: translateY(-2px);
        }
        
        /* Links කියවන්න ලේසි වෙන්න light blue පාට කළා */
        .link-btn { 
            text-decoration: none; 
            color: #80c1ff; 
            font-size: 15px; 
            font-family: Arial; 
            transition: 0.3s;
        }
        
        .link-btn:hover { 
            color: #ff4d4d;
            text-decoration: underline;
        }
        
        .error { 
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid red;
            color: #ffb3b3; 
            font-size: 16px; 
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 25px; 
        }
    </style>
</head>
<body>

    <h1>Blood Donation Management System</h1>
    <h2>LOGIN</h2>

    <div class="login-box">
        <?php if($error != "") { echo "<div class='error'>$error</div>"; } ?>

        <form name="form1" method="post" action="">
            <label>USER NAME</label><br>
            <input type="text" name="username" maxlength="25" autocomplete="off" required><br><br>

            <label>PASSWORD</label><br>
            <input type="password" name="password" maxlength="25" required><br><br>
            
            <a href="ForgetPassword.php" class="link-btn">Forget Password</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
            <a href="New Account1.php" class="link-btn">Create New Account</a>
            <br><br><br>
            
            <input type="submit" value="LOGIN" class="btn login-btn">
            <a href="javascript:history.back()" class="btn btn-danger">Exit</a>
        </form>
    </div>

</body>
</html>