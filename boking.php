<?php
session_start();

// PHPMailer සඳහා අවශ්‍ය පන්ති (Classes) ඇතුළත් කිරීම
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 💡 ඔබේ vendor ෆෝල්ඩරයේ පිහිටීමට අනුව Path එක නිවැරදිවම මෙසේ සකස් කරන ලදී:
require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if($conn->connect_error){ die("Connection Failed : " . $conn->connect_error); }

// 🔄 ADMIN APPROVAL, STOCK REDUCTION, RELEASE TRACKING & EMAIL NOTIFICATION LOGIC
if(isset($_POST['approve_booking'])){
    $approve_id = intval($_POST['booking_id']);
    $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
    $pickup_time = $conn->real_escape_string($_POST['pickup_time']);
    
    // Booking විස්තර ලබා ගැනීම
    $booking_res = $conn->query("SELECT * FROM blood_bookings WHERE id = $approve_id AND status = 'Pending'");
    
    if($booking_res && $booking_res->num_rows > 0){
        $booking = $booking_res->fetch_assoc();
        $b_name = $conn->real_escape_string($booking['name']);
        $b_email = $booking['email']; 
        $b_group = $booking['blood_group'];
        $b_units = intval($booking['units']);
        $b_hospital = $conn->real_escape_string($booking['hospital_name']);
        $b_address = $conn->real_escape_string($booking['address']); 

        // රෝහලේ ඇති තොගය ප්‍රමාණවත් දැයි බැලීම
        $stock_res = $conn->query("SELECT id, units FROM blood_stock WHERE name = '$b_hospital' AND blood_group = '$b_group' AND units >= $b_units LIMIT 1");

        if($stock_res && $stock_res->num_rows > 0){
            $stock = $stock_res->fetch_assoc();
            $stock_id = $stock['id'];

            // Transaction එකක් ආරම්භ කිරීම
            $conn->begin_transaction();
            try {
                // 1. Status එක Approved කිරීම
                $conn->query("UPDATE blood_bookings SET status = 'Approved' WHERE id = $approve_id");
                
                // 2. අදාළ රෝහලේ Stock එකෙන් අඩු කිරීම
                $conn->query("UPDATE blood_stock SET units = units - $b_units WHERE id = $stock_id");

                // 3. blood_releases ටේබල් එකට දත්ත ඇතුළත් කිරීම
                $release_sql = "INSERT INTO blood_releases (booking_id, patient_name, hospital_name, blood_group, units, address) 
                                VALUES ($approve_id, '$b_name', '$b_hospital', '$b_group', $b_units, '$b_address')";
                $conn->query($release_sql);

                // 📅 දිනය සහ වෙලාව කියවීමට පහසු ආකාරයට සකස් කිරීම
                $formatted_time = date("h:i A", strtotime($pickup_time));
                $formatted_date = date("F j, Y", strtotime($pickup_date));

                // 📧 4. PHPMailer මඟින් ඊමේල් එක සත්‍ය ලෙසම පිටත් කිරීමේ කේතය
                $mail = new PHPMailer(true);

                // SMTP Settings (Gmail භාවිතයෙන් ඊමේල් යැවීමට)
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'sandarekaishani83@gmail.com';  // 💡 ඔබේ සිස්ටම් එක වෙනුවෙන් භාවිතා කරන Gmail ලිපිනය
                $mail->Password   = 'zmnr dbgs jxhv kqqk';     // 💡 Gmail App Password එකක් සාදා මෙතැනට දෙන්න
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('no-reply@blooddonationsystem.com', 'Blood Donation System');
                $mail->addAddress($b_email, $b_name); 

                // Content
                $mail->isHTML(true);
                $mail->Subject = "🚨 Urgent: Blood Request Approved & Ready for Pickup";
                
                $mail->Body = "
                <html>
                <body style='font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;'>
                    <div style='max-width: 600px; background: white; border-radius: 10px; padding: 20px; border-top: 5px solid #8e0000; box-shadow: 0 0 10px #ccc; margin: 0 auto;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #8e0000; margin: 0;'>Blood Donation Management System</h2>
                        </div>
                        <h3 style='color: #333;'>Dear $b_name,</h3>
                        <p style='font-size: 16px; color: #444; line-height: 1.6;'>
                            We are pleased to inform you that your emergency blood request has been <strong>Approved</strong> by the administrator and the stock has been officially released.
                        </p>
                        
                        <div style='background-color: #fff5f5; border-left: 4px solid #8e0000; padding: 15px; margin: 20px 0; border-radius: 4px;'>
                            <h4 style='color: #8e0000; margin-top: 0; margin-bottom: 10px;'>📍 Collection Instructions & Details:</h4>
                            <p style='margin: 5px 0; font-size: 15px;'>Please visit the following location to collect the blood bags:</p>
                            <p style='margin: 8px 0; font-size: 16px; font-weight: bold; color: #2c3e50;'>🏥 Hospital: $b_hospital</p>
                            <p style='margin: 5px 0; font-size: 14px; color: #555;'>🗺️ Address: $b_address</p>
                            <hr style='border:0; border-top: 1px dashed #f0b4b4; margin: 10px 0;'>
                            <p style='margin: 5px 0; font-size: 15px; font-weight: bold; color: #d35400;'>📅 Scheduled Date: $formatted_date</p>
                            <p style='margin: 5px 0; font-size: 15px; font-weight: bold; color: #d35400;'>⏰ Scheduled Time: $formatted_time</p>
                        </div>

                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        <h4 style='color: #333;'>Request Summary:</h4>
                        <table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>
                            <tr><td style='padding: 6px 0; color: #666;'>Blood Group:</td><td style='color: #8e0000; font-weight: bold;'>$b_group</td></tr>
                            <tr><td style='padding: 6px 0; color: #666;'>Quantity:</td><td style='font-weight: bold;'>$b_units Units / Bags</td></tr>
                        </table>
                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        
                        <p style='font-size: 13px; color: #777; font-style: italic; margin-top: 15px;'>
                            Note: Please make sure to bring necessary cooling storage bags/boxes and the original medical recommendation documents when you come for the pickup.
                        </p>
                        <p style='font-size: 14px; color: #333; margin-top: 25px;'>Thank you,<br><strong>Admin Panel - Blood Donation System</strong></p>
                    </div>
                </body>
                </html>
                ";

                $mail->send();

                $conn->commit();
                echo "<script>alert('🎉 Blood Released Successfully! Pickup Instructions Email Sent to Patient.'); window.location.href='boking.php';</script>";
            } catch (Exception $e) {
                $conn->rollback();
                echo "<script>alert('Error occurred or Email sending failed. Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('❌ Cannot Approve! Insufficient stock in $b_hospital.'); window.location.href='boking.php';</script>";
        }
    }
}

// දත්ත ලබා ගැනීම
$query = "SELECT * FROM blood_bookings ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Booking Details - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Arial, sans-serif; }
        .topbar { background: #8e0000; color: white; padding: 15px; }
        .container-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 30px; }
        .table th { background-color: #8e0000 !important; color: white !important; }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <h3>Blood Donation System - Admin Panel</h3>
    <div>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm me-2">Admin Dashboard</a>
        <a href="login.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
</div>

<div class="container mb-5">
    <div class="container-box">
        <h2 class="text-center mb-4" style="color: #8e0000; font-weight:bold;">🩸 Blood Booking Management</h2>
        
        <div class="d-flex justify-content-between mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
            <a href="released_list.php" class="btn btn-danger fw-bold shadow-sm" style="background-color: #bdc3c7; color: #2c3e50; border:none;">
                📋 View Released History
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requester / Patient Details</th>
                        <th>Blood Group & Units</th>
                        <th>Hospital Name & Address</th>
                        <th>Required Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                            $status = $row['status'];
                            $badge_class = "bg-warning text-dark"; 
                            if($status == "Approved") $badge_class = "bg-success";
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                            <span class="text-muted small">📞 <?php echo htmlspecialchars($row['phone']); ?></span><br>
                            <span class="text-muted small">✉️ <?php echo htmlspecialchars($row['email']); ?></span>
                        </td>
                        <td>
                            <span class="badge bg-danger fs-6"><?php echo htmlspecialchars($row['blood_group']); ?></span><br>
                            <span class="fw-bold text-dark"><?php echo $row['units']; ?> Units</span>
                        </td>
                        <td>
                            <strong>📍 <?php echo htmlspecialchars($row['hospital_name']); ?></strong><br>
                            <span class="text-muted small"><?php echo htmlspecialchars($row['address']); ?></span>
                        </td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><span class="badge <?php echo $badge_class; ?> p-2"><?php echo $status; ?></span></td>
                        <td class="text-center">
                            <?php if($status == 'Pending') { ?>
                                <button type="button" class="btn btn-success btn-sm fw-bold px-3 open-approve-modal" 
                                        data-id="<?php echo $row['id']; ?>" 
                                        data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                                        data-hospital="<?php echo htmlspecialchars($row['hospital_name']); ?>">
                                     ✓ Approve & Release
                                </button>
                            <?php } else { ?>
                                <span class="text-success fw-bold">✓ Released</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted py-4'>No bookings found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8e0000; color: white;">
        <h5 class="modal-title" id="approveModalLabel">🩸 Schedule Blood Pickup</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="boking.php">
          <div class="modal-body">
                <input type="hidden" name="booking_id" id="modal_booking_id">
                
                <p>You are approving the request for <strong id="modal_patient_name" class="text-danger"></strong>. Blood will be released from <strong id="modal_hospital_name"></strong>.</p>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Pickup Date:</label>
                    <input type="date" name="pickup_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Pickup Time:</label>
                    <input type="time" name="pickup_time" class="form-control" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="approve_booking" class="btn btn-success fw-bold">Confirm & Send Email</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const approveButtons = document.querySelectorAll('.open-approve-modal');
    const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
    
    approveButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('modal_booking_id').value = this.getAttribute('data-id');
            document.getElementById('modal_patient_name').textContent = this.getAttribute('data-name');
            document.getElementById('modal_hospital_name').textContent = this.getAttribute('data-hospital');
            approveModal.show();
        });
    });
</script>
</body>
</html>