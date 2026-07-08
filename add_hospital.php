<?php

$conn = new mysqli("localhost","root","","blood_donations");

if(isset($_POST['save'])){

$name = $_POST['name'];
$location = $_POST['location'];
$contact = $_POST['contact'];
$province = $_POST['province'];
$district = $_POST['district'];

$conn->query("INSERT INTO hospitals(name,location,contact,province,district)
VALUES('$name','$location','$contact','$province','$district')");

header("Location:view_hospitals.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Hospital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="card p-4">

<h2>Add Hospital</h2>

<form method="post">

<input type="text" name="name"
class="form-control mb-3"
placeholder="Hospital Name" required>

<input type="text" name="location"
class="form-control mb-3"
placeholder="Location" required>

<input type="text" name="contact"
class="form-control mb-3"
placeholder="Contact Number" required>

<input type="text" name="province"
class="form-control mb-3"
placeholder="Province" required>

<input type="text" name="district"
class="form-control mb-3"
placeholder="District" required>



<button name="save"
class="btn btn-success">
Save Hospital
</button>

</form>

</div>

</div>

</body>
</html>