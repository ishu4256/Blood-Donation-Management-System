<?php
// Database Connection Setup
$servername = "localhost";
$username   = "root"; 
$password   = ""; 
$dbname     = "blood_donations"; // හෝ ඔබේ Database Name එක check කරගන්න

$conn = new mysqli($servername, $username, $password, $dbname);

// Connection Error Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $area  = trim($_POST['area'] ?? '');
    
    // Preferred Area (Checkboxes / Array හෝ Single value handling)
    if (isset($_POST['preferred_area'])) {
        if (is_array($_POST['preferred_area'])) {
            $clean_areas = array_map('htmlspecialchars', $_POST['preferred_area']);
            $preferred_area = implode(", ", $clean_areas);
        } else {
            $preferred_area = htmlspecialchars($_POST['preferred_area']);
        }
    } else {
        $preferred_area = 'None';
    }

    // SQL Injection වැළැක්වීම සඳහා Prepared Statements භාවිතය
    $stmt = $conn->prepare("INSERT INTO volunteers (name, email, phone, area, preferred_area) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $area, $preferred_area);

    if ($stmt->execute()) {
        echo "
        <div style='max-width: 600px; margin: 50px auto; padding: 30px; border: 1px solid #28a745; border-radius: 8px; font-family: Arial, sans-serif; text-align: center; background-color: #d4edda; color: #155724;'>
            <h2>Thank You, " . htmlspecialchars($name) . "! ❤️</h2>
            <p>You have successfully registered as a volunteer for our Donation Events.</p>
            <p>Your details have been saved securely in our database.</p>
            <hr style='border: 0; border-top: 1px solid #c3e6cb;'>
            <p>Our team will contact you very soon via <b>" . htmlspecialchars($email) . "</b>.</p>
            <a href='more.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background-color:#155724; color:white; text-decoration:none; border-radius:5px;'>Go Back</a>
        </div>
        ";
    } else {
        echo "<div style='color:red; text-align:center; padding:20px;'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: more.php");
    exit();
}
?>