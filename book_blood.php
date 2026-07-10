<?php
// ඩේටාබේස් සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}

// 💡 1. AJAX ඉල්ලීමක් (Request) ආවොත් රෝහල් ලැයිස්තුව විතරක් Output කර එතනින් Script එක නතර (exit) කරන්න
if (isset($_GET['blood_group_ajax'])) {
    $blood_group = $conn->real_escape_string($_GET['blood_group_ajax']);

    $query = "SELECT DISTINCT name FROM blood_stock WHERE blood_group = '$blood_group' AND units > 0 ORDER BY name ASC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        echo '<option value="" selected disabled>-- Select Hospital --</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    } else {
        echo '<option value="">❌ No hospitals available for this blood group</option>';
    }
    $conn->close();
    exit(); // 👈 වැදගත්: මුළු Form එකම ආයෙත් පල්ලෙහාට Render වෙන එක නවත්වන්න
}

// 💡 2. Form එක Submit කරපු වෙලාවට වැඩ කරන කොටස
if(isset($_POST['submit'])){
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $units = intval($_POST['units']);
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $booking_date = $conn->real_escape_string($_POST['booking_date']);

    if ($units > 5) {
        echo "<script>alert('Error: You can request a maximum of 5 units.'); window.location.href='book_blood.php';</script>";
        exit();
    }

    $sql = "INSERT INTO blood_bookings (name, email, phone, address, blood_group, units, hospital_name, booking_date, status)
            VALUES ('$name', '$email', '$phone', '$address', '$blood_group', $units, '$hospital_name', '$booking_date', 'Pending')";

    if($conn->query($sql) === TRUE){
        echo "<script>alert('🔒 Blood request booked successfully! Waiting for Admin Approval.'); window.location.href='donor.php';</script>";
        exit();
    }else{
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Booking Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9;">

<div class="container mt-5 mb-5" style="max-width: 800px;">
    <div class="card shadow p-4" style="border-radius: 12px; background: white;">
        <h2 class="text-center text-danger mb-4 fw-bold" style="color: #c0392b !important;">
            🩸 Blood Request Booking Form
        </h2>

        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter patient name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g., 0771234567" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Required Date</label>
                    <input type="date" name="booking_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Delivery / Hospital Address</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Enter complete address" required></textarea>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold text-danger">1. Blood Group</label>
                    <select class="form-select" id="blood_group_select" name="blood_group" onchange="fetchAvailableHospitals(this.value)" required>
                        <option value="" selected disabled>-- Select --</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                    </select>
                </div>

                <div class="col-md-5 mb-3">
                    <label class="form-label fw-semibold text-primary">2. Available Hospitals</label>
                    <select class="form-select" id="hospital_select" name="hospital_name" required disabled>
                        <option value="">-- Select Blood Group First --</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">3. Quantity (Max 5)</label>
                    <input type="number" name="units" class="form-control" min="1" max="5" value="1" oninput="if(this.value > 5) { alert('Maximum 5 units allowed!'); this.value = 5; }" required>
                    <small class="text-muted">Max 5 Bags</small>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <button type="submit" name="submit" class="btn btn-danger w-100 py-2 fw-bold" style="background-color: #dc3545; border: none;">Confirm Booking</button>
                </div>
                <div class="col-6">
                    <a href="javascript:history.back()" class="btn btn-secondary w-100 py-2 fw-bold">Exit</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function fetchAvailableHospitals(bloodGroup) {
    var hospitalSelect = document.getElementById("hospital_select");
    if (!bloodGroup) {
        hospitalSelect.innerHTML = '<option value="">-- Select Blood Group First --</option>';
        hospitalSelect.disabled = true;
        return;
    }

    var xhr = new XMLHttpRequest();
    // 💡 3. වෙනම file එකකට යන්නේ නැතිව, මේ පිටුවටම (book_blood.php) Request එක එවීම
    xhr.open("GET", "book_blood.php?blood_group_ajax=" + encodeURIComponent(bloodGroup), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            hospitalSelect.innerHTML = xhr.responseText;
            hospitalSelect.disabled = false;
        }
    };
    xhr.send();
}
</script>
</body>
</html>