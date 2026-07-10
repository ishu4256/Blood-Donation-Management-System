<?php
// 1. Database එකට සම්බන්ධ වීමට අවශ්‍ය විස්තර (Database Connection)
$servername = "localhost";
$username = "root";       // XAMPP වල default username එක root වේ
$password = "";           // XAMPP වල default password එක හිස් (empty) වේ
$dbname = "blood_donations"; // ඔයා හදපු database එකේ නම

// Connection එක සාදා ගැනීම
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection එකේ දෝෂයක් ඇත්දැයි පරීක්ෂා කිරීම
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form එක POST ක්‍රමයට ආවාදැයි පරීක්ෂා කිරීම
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // HTML Form එකෙන් එවපු Data ටික Variables වලට ගැනීම (Security එක සඳහා)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
$preferred_area = $conn->real_escape_string($_POST['preferred_area']); // උදව් කළ හැකි ක්ෂේත්‍රය
    // 2. Data ටික 'volunteers' table එකට ඇතුළත් කිරීමේ SQL Query එක
    $sql = "INSERT INTO volunteers (name, email, phone, area, preferred_area) VALUES ('$name', '$email', '$phone', '$area', '$preferred_area')";

    // Query එක සාර්ථකව ක්‍රියාත්මක වුනාදැයි බලන්න
    if ($conn->query($sql) === TRUE) {
        // සාර්ථක නම් User ට පෙන්වන පණිවිඩය (Success Message)
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
        // මොකක් හරි error එකක් ආවොත් පෙන්වන පණිවිඩය
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Connection එක Close කිරීම
    $conn->close();

} else {
    // කෙලින්ම PHP ෆයිල් එකට එන්න හැදුවොත් more.php එකට Redirect කරනවා
    header("Location: more.php");
    exit();
}
?>