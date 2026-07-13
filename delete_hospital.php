<?php

$conn = new mysqli("localhost","root","","blood_donations");

$id = $_GET['id'];

$conn->query("DELETE FROM hospitals WHERE id='$id'");


header("Location:view_hospitals.php");

?>