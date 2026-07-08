<?php
session_start();

// Security check (Admin ද කියා බැලීම)
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    exit("Unauthorized");
}

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    exit("<option value=''>Connection Failed</option>");
}

if(isset($_GET['district'])) {
    // ලැබෙන දිස්ත්‍රික්කයේ නම ආරක්ෂිතව ලබා ගැනීම
    $district = $conn->real_escape_string($_GET['district']);

    // දිස්ත්‍රික්කයට අදාළ රෝහල් SQL Query එක මඟින් ලබා ගැනීම
    $query = "SELECT name FROM hospitals WHERE district = '$district' ORDER BY name ASC";
    $result = $conn->query($query);

    if($result && $result->num_rows > 0) {
        echo '<option value="">-- Select Hospital --</option>';
        while($row = $result->fetch_assoc()) {
            $h_name = htmlspecialchars($row['name']);
            // Dropdown එකේ පෙන්වීමට මුල් අකුරු Capital (Ucwords) කර පෙන්වයි
            echo "<option value='".$h_name."'>".ucwords($h_name)."</option>";
        }
    } else {
        echo '<option value="">-- No Hospitals Found in this District --</option>';
    }
} else {
    echo '<option value="">-- Invalid Request --</option>';
}
?>

<?php
// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    exit("<option value=''>Connection Failed</option>");
}

if(isset($_GET['blood_group'])) {
    // තෝරාගත් ලේ වර්ගය ආරක්ෂිතව ලබා ගැනීම
    $blood_group = $conn->real_escape_string($_GET['blood_group']);

    // 💡 blood_stock එකේ එම ලේ වර්ගයෙන් බෑග් 1ක් හෝ ඊට වඩා වැඩිපුර ඇති රෝහල් පමණක් සෙවීම
    $query = "SELECT DISTINCT name, units FROM blood_stock 
              WHERE blood_group = '$blood_group' AND units > 0 
              ORDER BY name ASC";
              
    $result = $conn->query($query);

    if($result && $result->num_rows > 0) {
        echo '<option value="" selected disabled>-- Select Hospital --</option>';
        while($row = $result->fetch_assoc()) {
            $h_name = htmlspecialchars($row['name']);
            $available_units = $row['units'];
            
            // රෝහලේ නම සමඟ දැනට තිබෙන බෑග් ගණනද (Available Units) Dropdown එකේ පෙන්වයි
            echo "<option value='".$h_name."'>".ucwords($h_name)." (Available: ".$available_units." Units)</option>";
        }
    } else {
        // එම ලේ වර්ගයෙන් කිසිදු රෝහලක තොග නොමැති විට
        echo '<option value="">❌ No hospitals available with '.$blood_group.' stock</option>';
    }
} else {
    echo '<option value="">-- Invalid Request --</option>';
}
?>