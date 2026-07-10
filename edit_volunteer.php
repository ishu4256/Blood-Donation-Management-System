<?php
$conn = new mysqli("localhost", "root", "", "blood_donations");

if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}

// 1. අදාළ Volunteer ගේ දැනට පවතින දත්ත Database එකෙන් කියවීම
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $result = $conn->query("SELECT * FROM volunteers WHERE id='$id'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Volunteer not found!'); window.location.href='volunteers.php';</script>";
        exit();
    }
} else {
    header("Location: volunteers.php");
    exit();
}

// 2. Update Button එක ක්ලික් කළ විට දත්ත Update කිරීම
if (isset($_POST['update'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $area = $conn->real_escape_string($_POST['area']);
    $preferred_area = $conn->real_escape_string($_POST['preferred_area']);

    $sql = "UPDATE volunteers SET 
            name='$name', 
            email='$email', 
            phone='$phone', 
            area='$area', 
            preferred_area='$preferred_area' 
            WHERE id='$id'";

    if ($conn->query($sql)) {
        echo "<script>alert('Volunteer updated successfully!'); window.location.href='volunteers.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Volunteer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #31080c; font-family: Arial; }
        .card { max-width: 550px; margin: auto; box-shadow: 0 0 10px #ccc; border-radius: 10px; }
        h2 { color: #8e0000; font-weight: bold; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card p-4">
        <h2 class="text-center mb-4">Edit Volunteer Details</h2>

        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
            </div>

            <!-- 🗺️ Area / District Dropdown (කලින් තේරූ දිස්ත්‍රික්කය Auto-select වේ) -->
            <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Area / District</label>
                <select name="area" class="form-select" required>
                    <?php
                    $districts = ["Colombo", "Gampaha", "Kalutara", "Kandy", "Matale", "Nuwara Eliya", "Galle", "Matara", "Hambantota", "Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu", "Batticaloa", "Ampara", "Trincomalee", "Kurunegala", "Puttalam", "Anuradhapura", "Polonnaruwa", "Badulla", "Monaragala", "Ratnapura", "Kegalle"];
                    foreach ($districts as $dist) {
                        $selected = ($row['area'] == $dist) ? "selected" : "";
                        echo "<option value='$dist' $selected>$dist</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- 🛠️ Preferred Area Dropdown (කලින් තේරූ ක්ෂේත්‍රය Auto-select වේ) -->
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary">Preferred Area (උදව් කළ හැකි ක්ෂේත්‍රය)</label>
                <select name="preferred_area" class="form-select" required>
                    <option value="Event Organizing" <?php if($row['preferred_area'] == 'Event Organizing') echo 'selected'; ?>>Event Organizing (සංවිධාන කටයුතු)</option>
                    <option value="Logistics/Transport" <?php if($row['preferred_area'] == 'Logistics/Transport') echo 'selected'; ?>>Logistics/Transport (ප්‍රවාහන)</option>
                    <option value="Marketing/Promo" <?php if($row['preferred_area'] == 'Marketing/Promo') echo 'selected'; ?>>Marketing / Social Media</option>
                    <option value="Any" <?php if($row['preferred_area'] == 'Any') echo 'selected'; ?>>Any (ඕනෑම වැඩකටයුත්තක්)</option>
                    <option value="Other" <?php if($row['preferred_area'] == 'Other') echo 'selected'; ?>>Other (වෙනත්)</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="volunteers.php" class="btn btn-secondary px-4">Cancel</a>
                <button type="submit" name="update" class="btn btn-warning px-4 fw-bold">Update Details</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>