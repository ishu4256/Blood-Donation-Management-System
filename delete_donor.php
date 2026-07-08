<?php

$conn = new mysqli("localhost","root","","blood_donations");

$id = $_GET['id'];

$conn->query("DELETE FROM donor WHERE donor_id='$id'");

header("Location:view_donors.php");

?>