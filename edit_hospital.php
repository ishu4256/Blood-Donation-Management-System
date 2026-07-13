<?php

$conn = new mysqli("localhost","root","","blood_donations");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM hospitals WHERE id='$id'");
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

$name = $_POST['name'];
$location = $_POST['location'];
$contact = $_POST['contact'];

$conn->query("UPDATE hospitals SET

name='$name',
location='$location',
contact='$contact'

WHERE id='$id'");

header("Location:view_hospitals.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Hospital</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #31080c;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding-bottom: 50px;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.3);
            border: none;
            max-width: 550px;
            margin: 0 auto;
            color: #333333;
        }

        .edit-card h2 {
            color: #8e0000;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #8e0000;
            box-shadow: 0 0 0 0.25rem rgba(142, 0, 0, 0.15);
        }

        .btn-update {
            background-color: #de3545;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: all 0.2s;
        }

        .btn-update:hover {
            background-color: #b01a28;
            color: white;
        }

        .btn-back {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #ffffff;
            color: #31080c;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    
    <!-- Back Button -->
    <div class="text-center mb-4">
        <a href="view_hospitals.php" class="btn-back">
            ← Back to Hospitals Page
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="card edit-card p-4 p-md-5">
        <h2>Edit Hospital Details</h2>

        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Hospital Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Location / District</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Contact Number</label>
                <input type="text" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>" class="form-control" required>
            </div>

            <button type="submit" name="update" class="btn-update shadow-sm">
                Update Hospital Info
            </button>
        </form>
    </div>

</div>

</body>
</html>