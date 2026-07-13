<?php

$conn = new mysqli("localhost","root","","blood_donations");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM donor WHERE donor_id='$id'");
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$blood_group = $_POST['blood_group'];

$conn->query("UPDATE donor SET

full_name='$full_name',
phone='$phone',
email='$email',
blood_group='$blood_group'

WHERE donor_id='$id'");

header("Location:view_donors.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Donor</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body><br><br><center>
<div>
                <a href="view_donors.php" class="btn btn-secondary">
                    ← Back to Donors page
                </a>
            </div></center>
<div class="container mt-5">

<div class="card p-4">

<h2>Edit Donor</h2>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            

<form method="post">

<input type="text"
name="full_name"
value="<?php echo $row['full_name']; ?>"
class="form-control mb-3">

<input type="text"
name="phone"
value="<?php echo $row['phone']; ?>"
class="form-control mb-3">

<input type="email"
name="email"
value="<?php echo $row['email']; ?>"
class="form-control mb-3">

<select name="blood_group" class="form-control mb-3">

<option><?php echo $row['blood_group']; ?></option>

<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>AB+</option>
<option>AB-</option>
<option>O+</option>
<option>O-</option>

</select>


<button name="update"
class="btn btn-warning">

Update Donor

</button>

</form>

</div>

</div>

</body>
</html>