<?php
session_start();

if(!isset($_SESSION['otp'])){
    die("OTP session expired!");
}

if(isset($_POST['verify'])){

    $entered_otp = $_POST['otp'];

    if($entered_otp == $_SESSION['otp']){

        header("Location: NewPassword.php");
        exit();

    } else {
        echo "Invalid OTP!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Blood Donation Management System</title>

    <style type="text/css">

        body{
            font-family: Arial;
            background-color:#f2f2f2;
        }

        h1{
            background-color: red;
            color: white;
            font-size: 50px;
            padding: 20px;
            margin:0;
        }

        h2{
            background-color:white;
            color: black;
            font-size: 40px;
            margin-top:20px;
        }

        .login-box{
            width:500px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0px 0px 10px gray;
            text-align:center;
            color:black;
            font-size:18px;
                        font-family: Arial;
        }

        label{
            font-size:20px;
            font-weight:bold;
        }

        input[type=text], input[type=password]{
            width:80%;
            padding:10px;
            margin:10px;
            font-size:18px;
        }

        .btn{
            padding:12px 25px;
            font-size:18px;
            text-decoration:none;
            border:none;
            cursor:pointer;
            border-radius:5px;
        }

        


        .error{
            color:red;
            font-size:20px;
            margin-bottom:15px;
        }

    </style>
</head>

<body>

    <div class="d1">
        <center><h1>Blood Donation Management System</h1></center>
    </div>

    <div class="d2">
        <center><h2>Forget Password</h2></center>
    </div>

    <div class="login-box">


<h2>Your OTP is: <?php echo $_SESSION['otp']; ?></h2>

<form method="POST">
    Enter OTP: <input type="text" name="otp" required><br><br>
    <input type="submit" name="verify" value="OKAY">
</form>
</div>
</body>
</html>