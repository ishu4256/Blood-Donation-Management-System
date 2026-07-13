<?php
session_start();

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    exit("Unauthorized");
}

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    exit("<option value=''>Connection Failed</option>");
}

if(isset($_GET['district'])) {
    // district eke nama labaganima
    $district = $conn->real_escape_string($_GET['district']);

    // district ekata adala SQL Query ekak magin laba ganimata
    $query = "SELECT name FROM hospitals WHERE district = '$district' ORDER BY name ASC";
    $result = $conn->query($query);

    if($result && $result->num_rows > 0) {
        echo '<option value="">-- Select Hospital --</option>';
        while($row = $result->fetch_assoc()) {
            $h_name = htmlspecialchars($row['name']);
            // Dropdown eke penwanna Capital (Ucwords) lesa
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
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    exit("<option value=''>Connection Failed</option>");
}

if(isset($_GET['blood_group'])) {
    $blood_group = $conn->real_escape_string($_GET['blood_group']);

    // 💡 blood_stock eke e blood ek 1k hari ita wada wediyen thiyana hospital pennnna
    $query = "SELECT DISTINCT name, units FROM blood_stock 
              WHERE blood_group = '$blood_group' AND units > 0 
              ORDER BY name ASC";
              
    $result = $conn->query($query);

    if($result && $result->num_rows > 0) {
        echo '<option value="" selected disabled>-- Select Hospital --</option>';
        while($row = $result->fetch_assoc()) {
            $h_name = htmlspecialchars($row['name']);
            $available_units = $row['units'];
            
            // hospital name, (Available Units) Dropdown 
            echo "<option value='".$h_name."'>".ucwords($h_name)." (Available: ".$available_units." Units)</option>";
        }
    } else {
        // onama hospital ekek e blood ek nathnm
        echo '<option value="">❌ No hospitals available with '.$blood_group.' stock</option>';
    }
} else {
    echo '<option value="">-- Invalid Request --</option>';
}
?>