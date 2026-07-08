<?php

$conn = new mysqli("localhost","root","","blood_donations");

if(isset($_POST['save'])){

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$area = $_POST['area'];
$registered_at = date('Y-m-d H:i:s');

$conn->query("INSERT INTO volunteers(name,email,phone,area,registered_at)
VALUES('$name','$email','$phone','$area','$registered_at')");

header("Location:volunteers.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Volunteer</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="card p-4">

<h2>Add Volunteer</h2>

<form method="post">

<input type="text" name="name"
class="form-control mb-3"
placeholder="Name" required>

<input type="email" name="email"
class="form-control mb-3"
placeholder="Email" required>

<input type="text" name="phone"
class="form-control mb-3"
placeholder="Phone" required>

<input type="text" name="area"
class="form-control mb-3"
placeholder="Area" required>

<input type="text" name="registered_at"
class="form-control mb-3"
placeholder="Registered At" required>

<button name="save"
class="btn btn-success">
Save Volunteer
</button>

</form>

</div>

</div>

</body>
</html>