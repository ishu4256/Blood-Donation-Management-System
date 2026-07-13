<?php

$conn = new mysqli("localhost","root","","blood_donations");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$result = $conn->query("SELECT * FROM hospitals ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>View Hospitals</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#31080c;
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

        <a href="admin_dashboard.php"
        class="btn btn-secondary mb-3">
            Back
        </a>

        <table class="table table-bordered table-striped">

            <tr class="table-primary">

                <th>ID</th>
                <th>Hospital Name</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Province</th>
                <th>District</th>
                <th>Actions</th>

            </tr>

            <?php while($row = $result->fetch_assoc()) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['location']; ?></td>

                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['province']; ?></td>
                <td><?php echo $row['district']; ?></td>
                <td>

                    <a href="edit_hospital.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="delete_hospital.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this hospital?')">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

        <a href="add_hospital.php"
        class="btn btn-success">
            Add New Hospital
        </a>

    </div>

</div>


</body>
</html>