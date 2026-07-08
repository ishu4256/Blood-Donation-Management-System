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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body><br><br><br><center>
<div>
                <a href="view_hospitals.php" class="btn btn-secondary">
                    ← Back to Hospitals page
                </a>
            </div></center>
<div class="container mt-5">

<div class="card p-4">

<h2>Edit Hospital</h2>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            

<form method="post">

<input type="text"
name="name"
value="<?php echo $row['name']; ?>"
class="form-control mb-3">

<input type="text"
name="location"
value="<?php echo $row['location']; ?>"
class="form-control mb-3">

<input type="text"
name="contact"
value="<?php echo $row['contact']; ?>"
class="form-control mb-3">

<button name="update"
class="btn btn-warning">
Update Hospital
</button>

</form>

</div>

</div>

</body>
</html>