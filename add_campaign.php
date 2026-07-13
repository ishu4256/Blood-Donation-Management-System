<?php
session_start();


// databse connection
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$message = "";
$message_class = "";


// campaign add karana eka database ekata
if(isset($_POST['submit'])){
    $title = $conn->real_escape_string($_POST['title']);
    $organizer = $conn->real_escape_string($_POST['organizer']);
    $location = $conn->real_escape_string($_POST['location']);
    $district = $conn->real_escape_string($_POST['district']);
    $campaign_date = $conn->real_escape_string($_POST['campaign_date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $description = $conn->real_escape_string($_POST['description']);


    //  'campaigns'  Table add the data 
    $sql = "INSERT INTO campaigns (title, organizer, location, district, campaign_date, start_time, end_time, description)
            VALUES ('$title', '$organizer', '$location', '$district', '$campaign_date', '$start_time', '$end_time', '$description')";

    if($conn->query($sql) === TRUE){
        $message = "🎉 Campaign Added Successfully!";
        $message_class = "alert-success";
       
        
        
    }else{
        $message = "❌ Error: " . $conn->error;
        $message_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Campaign - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #31080c;
            font-family: Arial, sans-serif;
        }
        .topbar {
            background: #8e0000;
            color: white;
            padding: 15px;
        }
        .container-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            margin-top: 30px;
            max-width: 700px;
        }
        h2 {
            color: #8e0000;
            font-weight: bold;
        }
        footer {
            background: #8e0000;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    
<br><br><br>
<center>
                <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
</center>

<div class="container mb-5 d-flex justify-content-center">

    <div class="container-box w-100">
        <h2 class="text-center mb-4">📢 Add New Blood Donation Campaign</h2>
        

        <?php if($message != ""): ?>
            <div class="alert <?php echo $message_class; ?> text-center fw-bold">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Campaign Title (වැඩසටහනේ නම)</label>
                <input type="text" name="title" class="form-control" placeholder="Eg: Annual Blood Drive 2026" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Organizer / Club (සංවිධානය කළ අය)</label>
                <input type="text" name="organizer" class="form-control" placeholder="Eg: Leo Club / Youth Society" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Location / Venue (ස්ථානය)</label>
                <input type="text" name="location" class="form-control" placeholder="Eg: Community Hall, Matara" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">District (දිස්ත්‍රික්කය)</label>
                <select name="district" class="form-select" required>
                    <option value="">Select District</option>
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
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Date (දිනය)</label>
                    <input type="date" name="campaign_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Start Time (ආරම්භක වේලාව)</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">End Time (අවසාන වේලාව)</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Description / Special Remarks (විස්තරය)</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Add any special instructions or details here..."></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-danger w-100 py-2 fw-bold" style="background-color: #8e0000; border: none;">
                📢 Publish Campaign
            </button>

        </form>
    </div>
    <br>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>