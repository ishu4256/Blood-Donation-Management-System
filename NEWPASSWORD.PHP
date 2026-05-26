<?php
session_start();
$conn = new mysqli("localhost","root","","blood_donations");

if(!isset($_SESSION['reset_username'])){
    die("Session expired!");
}

if(isset($_POST['reset'])){

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password == $confirm_password){

        $username = $_SESSION['reset_username'];

        $sql = "UPDATE users 
                SET password='$new_password' 
                WHERE username='$username'";

        if($conn->query($sql) === TRUE){

            session_destroy();

            header("Location: login.php");
            exit();

        } else {
            echo "Password update failed!";
        }

    } else {
        echo "Passwords do not match!";
    }
}
?>

<form method="POST">
    New Password: <input type="password" name="new_password" required><br><br>
    Confirm Password: <input type="password" name="confirm_password" required><br><br>
    <input type="submit" name="reset" value="SUBMIT">
</form>