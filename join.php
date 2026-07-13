<?php
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "blood_donations"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
$preferred_area = $conn->real_escape_string($_POST['preferred_area']); 


$sql = "INSERT INTO volunteers (name, email, phone, area, preferred_area) VALUES ('$name', '$email', '$phone', '$area', '$preferred_area')";

    // Query is successful
    if ($conn->query($sql) === TRUE) {
        echo "
        <div style='max-width: 600px; margin: 50px auto; padding: 30px; border: 1px solid #28a745; border-radius: 8px; font-family: Arial, sans-serif; text-align: center; background-color: #d4edda; color: #155724;'>
            <h2>Thank You, $name! ❤️</h2>
            <p>You have successfully registered as a volunteer for our Donation Events.</p>
            <p>Your details have been saved securely in our database.</p>
            <hr style='border: 0; border-top: 1px solid #c3e6cb;'>
            <p>Our team will contact you very soon via <b>$email</b>.</p>
            <a href='more.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background-color:#155724; color:white; text-decoration:none; border-radius:5px;'>Go Back</a>
        </div>
        ";
    } else {
        // error awoth pennana eka
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Connection  Close kirima
    $conn->close();

} else {
    header("Location: more.php");
    exit();
}
?>