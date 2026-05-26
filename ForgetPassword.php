<?php
session_start();

$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

if(isset($_POST['done'])){

    $username = $_POST['username'];
    $phone = $_POST['phone'];

   $sql = "SELECT * FROM donor_details
        WHERE contact_no='$phone'";

    $result = $conn->query($sql);
echo "<pre>";
print_r($result);
echo "</pre>";
    if($result->num_rows > 0){

        $otp = rand(100000,999999);

        $_SESSION['reset_username'] = $username;
        $_SESSION['otp'] = $otp;

        header("Location: VerifyOTP.php");
        exit();

    } else {
        echo "Invalid Username or Phone Number!";
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

        .d1{
            background-color:red;
            color:white;
        }

        

        .login-box{
            color:black;
            font-size:18px;
                        font-family: Arial;

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
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Phone Number: <input type="text" name="phone" required><br><br>
    <input type="submit" name="done" value="DONE">
</form>
</div>
</body>
</html>