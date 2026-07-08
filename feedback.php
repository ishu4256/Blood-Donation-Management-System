<?php
session_start();
// පරිශීලකයා ලොග් වී ඇත්දැයි පරීක්ෂා කිරීම
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_donations");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$msg = "";

if (isset($_POST['submit_feedback'])) {
    $username = $_SESSION['username']; // ලොග් වී සිටින යූසර්ගේ නම
    $message = $conn->real_escape_string($_POST['message']);

    if (!empty($message)) {
        $sql = "INSERT INTO feedback (username, message) VALUES ('$username', '$message')";
        if ($conn->query($sql) === TRUE) {
            $msg = "<div class='alert alert-success'>Thank you for your feedback!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please enter your message.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: Arial, sans-serif; }
        .feedback-card { max-width: 600px; margin: 60px auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .btn-custom { background-color: #8e0000; color: white; font-size: 18px; width: 140px; }
        .btn-custom:hover { background-color: #c0392b; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="feedback-card">
        <h2 class="text-center mb-4" style="color: #8e0000; font-weight: bold;">Send Us Your Feedback</h2>
        
        <?php echo $msg; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Your Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Write your thoughts here..." required></textarea>
            </div>

        <div class="text-center mt-4">
    <input type="submit" name="submit_feedback" value="Submit" class="btn btn-custom">
    <button type="button" class="btn btn-secondary ms-2" style="width: 140px; padding: 9px 0;" onclick="window.close();">Back</button>
</div>
        </form>
    </div>
</div>

</body>
</html>