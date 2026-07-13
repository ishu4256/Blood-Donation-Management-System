<?php
$conn = new mysqli("localhost", "root", "", "blood_donations");

if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}

if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $area = $conn->real_escape_string($_POST['area']);
    $preferred_area = $conn->real_escape_string($_POST['preferred_area']); 
    $registered_at = $conn->real_escape_string($_POST['registered_at']);

    $conn->query("INSERT INTO volunteers(name, email, phone, area, preferred_area, registered_at) 
                  VALUES('$name', '$email', '$phone', '$area', '$preferred_area', '$registered_at')");

    header("Location: volunteers.php");
    exit();
}


//timezone set kirima date and time ganna
date_default_timezone_set('Asia/Colombo');
$current_datetime = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Volunteer</title>
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
        <h2 class="text-center mb-4">Add Volunteer</h2>

        <form method="post">
            <label class="form-label fw-bold text-secondary">Full Name</label>
            <input type="text" name="name" class="form-control mb-3" placeholder="Enter Name" required>

            <label class="form-label fw-bold text-secondary">Email Address</label>
            <input type="email" name="email" class="form-control mb-3" placeholder="Enter Email" required>

            <label class="form-label fw-bold text-secondary">Phone Number</label>
            <input type="text" name="phone" class="form-control mb-3" placeholder="Enter Phone" required>

            <label class="form-label fw-bold text-secondary">Area / District</label>
            <select name="area" class="form-select mb-3" required>
                <option value="" disabled selected>Select Area</option>
                <option value="Colombo">Colombo</option>
                <option value="Gampaha">Gampaha</option>
                <option value="Kalutara">Kalutara</option>
                <option value="Kandy">Kandy</option>
                <option value="Matale">Matale</option>
                <option value="Nuwara Eliya">Nuwara Eliya</option>
                <option value="Galle">Galle</option>
                <option value="Matara">Matara</option>
                <option value="Hambantota">Hambantota</option>
                <option value="Jaffna">Jaffna</option>
                <option value="Kilinochchi">Kilinochchi</option>
                <option value="Mannar">Mannar</option>
                <option value="Vavuniya">Vavuniya</option>
                <option value="Mullaitivu">Mullaitivu</option>
                <option value="Batticaloa">Batticaloa</option>
                <option value="Ampara">Ampara</option>
                <option value="Trincomalee">Trincomalee</option>
                <option value="Kurunegala">Kurunegala</option>
                <option value="Puttalam">Puttalam</option>
                <option value="Anuradhapura">Anuradhapura</option>
                <option value="Polonnaruwa">Polonnaruwa</option>
                <option value="Badulla">Badulla</option>
                <option value="Monaragala">Monaragala</option>
                <option value="Ratnapura">Ratnapura</option>
                <option value="Kegalle">Kegalle</option>
            </select>

            <label class="form-label fw-bold text-secondary">Preferred Area (උදව් කළ හැකි ක්ෂේත්‍රය)</label>
            <select name="preferred_area" class="form-select mb-3" required>
                <option value="" disabled selected>Select Preferred Area</option>
                <option value="Event Organizing">Event Organizing (සංවිධාන කටයුතු)</option>
                <option value="Logistics/Transport">Logistics/Transport (ප්‍රවාහන)</option>
                <option value="Marketing / Social Media">Marketing / Social Media</option>
                <option value="Any">Any (ඕනෑම වැඩසටහනක්)</option>
            </select>

            <label class="form-label fw-bold text-secondary">Registered At</label>
            <input type="text" name="registered_at" class="form-control mb-4" value="<?php echo $current_datetime; ?>" readonly>

            <div class="d-flex justify-content-between">
                <a href="volunteers.php" class="btn btn-secondary px-4">Cancel</a>
                <button name="save" class="btn btn-success px-4">Save Volunteer</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>