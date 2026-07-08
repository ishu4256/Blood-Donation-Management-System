<?php
session_start();

// 1. පරිශීලකයා ලොග් වී නැත්නම් Login පිටුවට යොමු කිරීම
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // ලොග් වී සිටින පරිශීලකයාගේ Username එක

// Database සම්බන්ධතාවය
$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error) { 
    die("Connection Failed : " . $conn->connect_error); 
}

// try-catch බ්ලොක් එක නිවැරදිව වැඩ කිරීමට MySQLi වල Exceptions සක්‍රිය කිරීම
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$message = "";
$msg_class = "";

// 2. ලොග් වී සිටින පරිශීලකයාගේ 'donor_id' එක 'users' ටේබල් එකෙන් සොයා ගැනීම
$current_donor_id = 0;
$user_check = $conn->query("SELECT donor_id FROM users WHERE username = '$username'");
if ($user_check && $user_check->num_rows > 0) {
    $user_row = $user_check->fetch_assoc();
    $current_donor_id = intval($user_row['donor_id']);
}

// 3. විස්තර යාවත්කාලීන කිරීමේ කොටස (Update Profile Logic)
if (isset($_POST['update_profile'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    // මෙතන තිබුණු $name රේඛාව ඉවත් කරන ලදී (ප්‍රොෆයිල් එකෙන් කෙටි නම වෙනස් නොකරන බැවින්)
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $district = $conn->real_escape_string($_POST['district']);
    $province = $conn->real_escape_string($_POST['province']);
    $donor_id_to_update = intval($_POST['donor_id']);

    // ආරක්ෂිත පියවරක් ලෙස Form එකෙන් එන ID එක සහ ලොග් වී සිටින කෙනාගේ ID එක සමානදැයි බැලීම
    if ($donor_id_to_update > 0 && $donor_id_to_update === $current_donor_id) {
        
        $conn->begin_transaction();

        try {
            // ටේබල් 1: donor_details ටේබල් එක යාවත්කාලීන කිරීම (මෙහි 'name' තීරුව යාවත්කාලීන නොවේ)
            $update_details = "UPDATE donor_details SET 
                               full_name = '$full_name', 
                               contact_no = '$phone', 
                               email = '$email',
                               blood_group = '$blood_group',
                               district = '$district',
                               province = '$province'
                               WHERE donor_id = $donor_id_to_update";
            $conn->query($update_details);

            // ටේබල් 2: donor ටේබල් එක යාවත්කාලීන කිරීම
            $update_donor = "UPDATE donor SET 
                             full_name = '$full_name', 
                             phone = '$phone', 
                             email = '$email', 
                             blood_group = '$blood_group', 
                             Districrt = '$district',
                             Province = '$province'
                             WHERE donor_id = $donor_id_to_update";
            $conn->query($update_donor);

            $conn->commit();

            $message = "ඔබේ තොරතුරු සාර්ථකව යාවත්කාලීන කරන ලදී!";
            $msg_class = "alert-success";

        } catch (Exception $e) {
            $conn->rollback();
            $message = "දත්ත වෙනස් කිරීමට නොහැකි විය: " . $e->getMessage();
            $msg_class = "alert-danger";
        }
    } else {
        $message = "වලංගු නොවන පරිශීලක දත්ත සැකසීමක් (Unauthorized Action).";
        $msg_class = "alert-danger";
    }
}

// 4. වත්මන් දත්ත 'donor_details' එකෙන් ලබා ගැනීම
$user_data = null;
if ($current_donor_id > 0) {
    $fetch_query = "SELECT * FROM donor_details WHERE donor_id = $current_donor_id";
    $res = $conn->query($fetch_query);
    if ($res && $res->num_rows > 0) {
        $user_data = $res->fetch_assoc();
    }
}

if (!$user_data) {
    $user_data = [
        'full_name' => '',
        'contact_no' => '',
        'email' => '',
        'blood_group' => 'A+',
        'nic' => '',
        'district' => '',
        'province' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Blood Donation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin:0; padding:0; }
        .top-bar { background: #8e0000; padding: 15px 30px; }
        .profile-container { 
            background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px gray; margin-top: 30px; position: relative; z-index: 5;
        }
        .profile-header h2 { color: #8e0000; font-weight: bold; }
        footer { background: #8e0000; color: white; padding: 40px 20px; margin-top: 50px; }
        .form-control[readonly] { background-color: #e9ecef !important; cursor: not-allowed; }
        .form-control:not([readonly]) { background-color: #ffffff !important; cursor: text; }
    </style>
</head>
<body>

<div class="top-bar d-flex justify-content-between align-items-center">
    <div class="text-start">
        <span class="text-white fw-bold">👤 Logged in as: <?php echo htmlspecialchars($username); ?></span>
    </div>
    <div class="nav-buttons">
        <a href="Dashboard.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Back</a>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-container">
                
                <div class="profile-header text-center mb-4">
                    <h2>My Profile Details</h2>
                    <p class="text-muted">ඔබේ තොරතුරු බැලීම සහ වෙනස් කිරීම මෙහිදී සිදුකල හැක.</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $msg_class; ?> alert-dismissible fade show text-center" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="editBtn" class="btn btn-dark fw-bold px-4 shadow-sm" onclick="enableEditing()">✏️ Edit Profile</button>
                </div>

                <form action="" method="POST">
                    
                    <input type="hidden" name="donor_id" value="<?php echo $current_donor_id; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name (සම්පූර්ණ නම)</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" readonly required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone Number (දුරකථන අංකය)</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user_data['contact_no']); ?>" readonly required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email Address (ඊමේල් ලිපිනය)</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">District (දිස්ත්‍රික්කය)</label>
                            <input type="text" name="district" id="district" class="form-control" value="<?php echo htmlspecialchars($user_data['district']); ?>" readonly required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Province (පළාත)</label>
                            <input type="text" name="province" id="province" class="form-control" value="<?php echo htmlspecialchars($user_data['province']); ?>" readonly required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Blood Group (ලේ වර්ගය)</label>
                            <input type="text" id="blood_group_text" class="form-control" value="<?php echo htmlspecialchars($user_data['blood_group']); ?>" readonly>
                            
                            <select name="blood_group" id="blood_group_select" class="form-select d-none" required>
                                <option value="A+" <?php if($user_data['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                                <option value="A-" <?php if($user_data['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                                <option value="B+" <?php if($user_data['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                                <option value="B-" <?php if($user_data['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                                <option value="O+" <?php if($user_data['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                                <option value="O-" <?php if($user_data['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                                <option value="AB+" <?php if($user_data['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                                <option value="AB-" <?php if($user_data['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">National Identity Card (NIC)</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['nic']); ?>" readonly>
                        </div>
                    </div>

                    <div id="saveBtnContainer" class="d-none mt-4">
                        <button type="submit" name="update_profile" class="btn btn-success w-100 fw-bold py-2 shadow" style="background-color: #27ae60; border:none;">Save Changes (වෙනස්කම් සුරකින්න)</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p class="mb-0">Online Blood Donation System Sri Lanka © 2026</p>
    </div>
</footer>

<script>
function enableEditing() {
    const editBtn = document.getElementById('editBtn');
    const saveBtnContainer = document.getElementById('saveBtnContainer');
    const fields = ['full_name', 'phone', 'email', 'district', 'province'];
    const firstField = document.getElementById('full_name');

    if (firstField.readOnly === true) {
        fields.forEach(id => {
            const el = document.getElementById(id);
            if(el) { el.readOnly = false; }
        });

        document.getElementById('blood_group_text').classList.add('d-none');
        document.getElementById('blood_group_select').classList.remove('d-none');

        editBtn.innerText = "❌ Cancel";
        editBtn.classList.replace('btn-dark', 'btn-danger');
        saveBtnContainer.classList.remove('0-none'); // d-none වෙනුවට වැරදීමකින් 0-none තිබුණොත් නිවැරදි කරන්න
        saveBtnContainer.classList.remove('d-none');
        firstField.focus();
    } else {
        fields.forEach(id => {
            const el = document.getElementById(id);
            if(el) { el.readOnly = true; }
        });

        document.getElementById('blood_group_text').classList.remove('d-none');
        document.getElementById('blood_group_select').classList.add('d-none');

        editBtn.innerText = "✏️ Edit Profile";
        editBtn.classList.replace('btn-danger', 'btn-dark');
        saveBtnContainer.classList.add('d-none');
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>