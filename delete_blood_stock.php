<?php
$conn = new mysqli("localhost", "root", "", "blood_donations");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// URL eken id eka thiyadai chech karanna
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // SQL Injection walin araksha vimata
    $id = intval($_GET['id']);
    
    // data delete karanna
    $stmt = $conn->prepare("DELETE FROM blood_stock WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // data delet karata passe mul daththa pennana eka penvimata 
        header("Location: blood_stock_details.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    // ID ekk nathinam mekat yanawa
    header("Location: blood_stock_details.php");
    exit();
}

$conn->close();
?>