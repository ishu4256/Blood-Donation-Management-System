<?php
session_start();

// PHPMailer sadaha class hadanna
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// vendor folder eke pihitima anuwa PHPMailer files athulath kirima
require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

if(isset($_POST['register'])){

    $full_name = $conn->real_escape_string($_POST['full_name']);
    $nic = $conn->real_escape_string($_POST['nic']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    
    $Province = $conn->real_escape_string($_POST['Province']);
    $Districrt = $conn->real_escape_string($_POST['District']); 
    
    $weight = $conn->real_escape_string($_POST['weight']);
    $last_donation_date = $conn->real_escape_string($_POST['last_donation_date']);
    $diseases = $conn->real_escape_string($_POST['diseases']);
    $medicines = $conn->real_escape_string($_POST['medicines']);
    $availability_status = $conn->real_escape_string($_POST['availability_status']);

    // FILE UPLOAD
    $nic_copy = $_FILES['nic_copy']['name'];
    $profile_photo = $_FILES['profile_photo']['name'];

    $nic_tmp = $_FILES['nic_copy']['tmp_name'];
    $photo_tmp = $_FILES['profile_photo']['tmp_name'];

    if(!file_exists("uploads/nic")){
        mkdir("uploads/nic",0777,true);
    }

    if(!file_exists("uploads/profile")){
        mkdir("uploads/profile",0777,true);
    }

    move_uploaded_file($nic_tmp, "uploads/nic/".$nic_copy);
    move_uploaded_file($photo_tmp, "uploads/profile/".$profile_photo);

    // INSERT QUERY
    $sql = "INSERT INTO donor (
        full_name, nic, dob, gender, phone, email, address, blood_group, 
        Province, Districrt, weight, last_donation_date, diseases, medicines, 
        availability_status, nic_copy, profile_photo
    )
    VALUES (
        '$full_name', '$nic', '$dob', '$gender', '$phone', '$email', '$address', '$blood_group', 
        '$Province', '$Districrt', '$weight', '$last_donation_date', '$diseases', '$medicines', 
        '$availability_status', '$nic_copy', '$profile_photo'
    )";

    if($conn->query($sql) === TRUE){
        
        // email yawana kotasa
        if(!empty($email)){
            $mail = new PHPMailer(true);

            try {
                // SMTP Settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'sandarekaishani83@gmail.com'; 
                $mail->Password   = 'zmnrdbgsjxhvkqqk'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                // Localhost SSL Error ain karanna
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                // Recipients
                $mail->setFrom('sandarekaishani83@gmail.com', 'Blood Donation System');
                $mail->addAddress($email, $full_name); 

                // Content
                $mail->isHTML(true);
                $mail->Subject = "Thank You for Registering as a Blood Donor!";
                
                $mail->Body = "
                <html>
                <body style='font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;'>
                    <div style='max-width: 600px; background: white; border-radius: 10px; padding: 20px; border-top: 5px solid #8e0000; box-shadow: 0 0 10px #ccc; margin: 0 auto;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #8e0000; margin: 0;'>Blood Donation Management System</h2>
                        </div>
                        <h3 style='color: #333;'>Dear $full_name,</h3>
                        <p style='font-size: 16px; color: #444; line-height: 1.6;'>
                            Thank you for registering as a voluntary blood donor in our system. Your willingness to donate blood is highly appreciated and it can save precious human lives!
                        </p>
                        
                        <div style='background-color: #f9f9f9; border-left: 4px solid #2ecc71; padding: 15px; margin: 20px 0; border-radius: 4px;'>
                            <h4 style='color: #2c3e50; margin-top: 0; margin-bottom: 10px;'>📋 Your Registration Profile Details:</h4>
                            <p style='margin: 5px 0; font-size: 15px;'><strong>NIC Number:</strong> $nic</p>
                            <p style='margin: 5px 0; font-size: 15px;'><strong>Blood Group:</strong> <span style='color: #8e0000; font-weight: bold; font-size: 16px;'>$blood_group</span></p>
                            <p style='margin: 5px 0; font-size: 15px;'><strong>District:</strong> $Districrt ($Province)</p>
                            <p style='margin: 5px 0; font-size: 15px;'><strong>Current Status:</strong> <span style='color: #27ae60; font-weight: bold;'>$availability_status</span></p>
                        </div>

                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        <p style='font-size: 14px; color: #555; line-height: 1.5;'>
                            When there is an emergency requirement for your blood group in your area, an administrator or a hospital representative will contact you via your phone number (<strong>$phone</strong>).
                        </p>
                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        
                        <p style='font-size: 13px; color: #777; font-style: italic; margin-top: 15px;'>
                            Note: If you need to change your availability status or update your profile details in the future, please contact our support team.
                        </p>
                        <p style='font-size: 14px; color: #333; margin-top: 25px;'>Best Regards,<br><strong>Blood Donation Management Team</strong></p>
                    </div>
                </body>
                </html>
                ";

                $mail->send();
            } catch (Exception $e) {
                // Error handle if needed
            }
        }

        echo "<script>alert('🎉 Registration Successful! Welcome Email Sent.Please Check your email'); window.location.href='donor.php';</script>";
        exit();
    } else {
        echo "Error : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#f4f6f9; font-family: Arial, sans-serif; }
        .card{ border:none; border-radius:20px; }
        .btn-danger{ padding:12px; border-radius:10px; font-weight:bold; }
        h2{ font-weight:bold; }
        label{ font-weight:600; }
        .form-control, .form-select{ border-radius:10px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow p-4">
                <h2 class="text-center text-danger mb-4">Register as a Donor</h2>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NIC Number</label>
                            <input type="text" name="nic" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Blood Group</label>
                            <select name="blood_group" class="form-select">
                                <option value="">Select</option>
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Province</label>
                            <select name="Province" id="provinceSelect" class="form-select" onchange="updateDistricts()" required>
                                <option value="">Select Province</option>
                                <option value="Western">Western Province</option>
                                <option value="Southern">Southern Province</option>
                                <option value="Central">Central Province</option>
                                <option value="Eastern">Eastern Province</option>
                                <option value="North Central">North Central Province</option>
                                <option value="Northern">Northern Province</option>
                                <option value="North Western">North Western Province</option>
                                <option value="Uva">Uva Province</option>
                                <option value="Sabaragamuwa">Sabaragamuwa Province</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>District</label>
                            <select name="District" id="districtSelect" class="form-select" required>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Weight</label>
                            <input type="number" name="weight" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Donation Date</label>
                            <input type="date" name="last_donation_date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Diseases</label>
                        <textarea name="diseases" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Medicines</label>
                        <textarea name="medicines" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Availability Status</label>
                        <select name="availability_status" class="form-select">
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIC Copy</label>
                            <input type="file" name="nic_copy" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                        </div>
                    </div>

                    <button type="submit" name="register" class="btn btn-danger w-100 mb-3">
                        Register as Donor
                    </button>
                    
                    <a href="javascript:history.back()" class="btn btn-secondary w-100">Exit</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateDistricts() {
    const provinceSelect = document.getElementById('provinceSelect');
    const districtSelect = document.getElementById('districtSelect');
    const selectedProvince = provinceSelect.value;

    const districts = {
        "Western": ["Colombo", "Gampaha", "Kalutara"],
        "Southern": ["Galle", "Matara", "Hambantota"],
        "Central": ["Kandy", "Matale", "Nuwara Eliya"],
        "Eastern": ["Trincomalee", "Batticaloa", "Ampara"],
        "North Central": ["Anuradhapura", "Polonnaruwa"],
        "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Mullaitivu", "Vavuniya"],
        "North Western": ["Kurunegala", "Puttalam"],
        "Uva": ["Badulla", "Monaragala"],
        "Sabaragamuwa": ["Ratnapura", "Kegalle"]
    };

    districtSelect.innerHTML = '<option value="">Select District</option>';

    if (selectedProvince && districts[selectedProvince]) {
        districts[selectedProvince].forEach(function(district) {
            const option = document.createElement('option');
            option.value = district;
            option.text = district;
            districtSelect.appendChild(option);
        });
    }
}
</script>

</body>
</html>