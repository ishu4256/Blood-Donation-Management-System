<?php
// 1. Database එකට සම්බන්ධ වීම
$conn = new mysqli("localhost", "root", "", "blood_donations");

// සම්බන්ධතාවය පරීක්ෂා කිරීම
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// URL එක හරහා දත්තයේ ID එක ලැබී ඇත්දැයි පරීක්ෂා කිරීම
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // SQL Injection වලින් ආරක්ෂා වීමට ID එක Integer එකක් බවට පත් කිරීම
    $id = intval($_GET['id']);
    
    // දත්තය මැකීම සඳහා Prepared Statement භාවිතය (ආරක්ෂිත ක්‍රමය)
    $stmt = $conn->prepare("DELETE FROM blood_stock WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // සාර්ථකව මැකුණු පසු නැවත මුල් දත්ත ලැයිස්තුව පෙන්වන පිටුවට යොමු කිරීම
        header("Location: blood_stock_details.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    // ID එකක් ලැබී නොමැති නම් කෙලින්ම මුල් පිටුවට යොමු කිරීම
    header("Location: blood_stock_details.php");
    exit();
}

$conn->close();
?>