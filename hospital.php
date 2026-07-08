<?php

$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$result = $conn->query("SELECT * FROM hospitals");

?>

<!DOCTYPE html>
<html>
<head>

<title>View Hospitals</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}

.container-box{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
    margin-top:30px;
}

h2{
    color:#8e0000;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

    <div class="container-box">

        <h2 class="text-center mb-4">
            Registered Hospitals
        </h2>

        

        <table class="table table-bordered table-striped">

            <tr class="table-primary">

                <th>ID</th>
                <th>Hospital Name</th>
                <th>Location</th>
                <th>Contact</th>

            </tr>

            <?php while($row = $result->fetch_assoc()) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['location']; ?></td>

                <td><?php echo $row['contact']; ?></td>

               

            </tr>

            <?php } ?>

        </table>

        

    </div>
<div class="text-center mt-4">
    <button type="button" class="btn btn-secondary ms-2" style="width: 140px; padding: 9px 0;" onclick="window.close();">Back</button>
</div>
</div>

</body>
</html>