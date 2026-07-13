<?php
// Database sambandhathaya (Database Connection)
$conn = new mysqli("localhost", "root", "", "blood_donations");

if($conn->connect_error){
    die("Connection Failed : " . $conn->connect_error);
}

$search_result = null;
$searched_group = "";

// Search button eka click kalama kriyaathmaka vana kotasa
if(isset($_POST['search_blood'])){
    $searched_group = $conn->real_escape_string($_POST['blood_group']);
    
    
    // donorslata adala blood group ek ganima saha status eka "Available" una donorsla ganna query ekak
    $search_query = "SELECT * FROM donors WHERE blood_group = '$searched_group' AND status = 'Available'";
    $search_result = $conn->query($search_query);
}
?>

<div class="container mt-5 mb-5" style="font-family: Arial, sans-serif;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4" style="border-radius: 12px; background: white;">
                <h3 class="text-center fw-bold mb-4" style="color: #8e0000;">🔍 Smart Blood Availability Search</h3>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="blood_group" class="form-label fw-bold text-dark">Select Blood Group</label>
                        <select class="form-select form-select-lg" id="blood_group" name="blood_group" required>
                            <option value="" selected disabled>-- Choose Blood Group --</option>
                            <option value="A+" <?php if($searched_group == 'A+') echo 'selected'; ?>>A+</option>
                            <option value="A-" <?php if($searched_group == 'A-') echo 'selected'; ?>>A-</option>
                            <option value="B+" <?php if($searched_group == 'B+') echo 'selected'; ?>>B+</option>
                            <option value="B-" <?php if($searched_group == 'B-') echo 'selected'; ?>>B-</option>
                            <option value="AB+" <?php if($searched_group == 'AB+') echo 'selected'; ?>>AB+</option>
                            <option value="AB-" <?php if($searched_group == 'AB-') echo 'selected'; ?>>AB-</option>
                            <option value="O+" <?php if($searched_group == 'O+') echo 'selected'; ?>>O+</option>
                            <option value="O-" <?php if($searched_group == 'O-') echo 'selected'; ?>>O-</option>
                        </select>
                    </div>
                    <button type="submit" name="search_blood" class="btn btn-danger btn-lg w-100 fw-bold shadow">Check Availability</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <?php if($search_result !== null): ?>
                <?php if($search_result->num_rows > 0): ?>
                    <div class="alert alert-success text-center fw-bold fs-5 shadow-sm mb-4">
                        🩸 <?php echo htmlspecialchars($searched_group); ?> Blood Group is AVAILABLE!
                    </div>
                    
                    <div class="card shadow-sm p-3">
                        <h5 class="text-dark fw-bold mb-3">Available Donors List:</h5>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="table-dark" style="background-color: #8e0000 !important;">
                                    <tr>
                                        <th>Donor Name</th>
                                        <th>Location</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $search_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                        <td>📍 <?php echo htmlspecialchars($row['location']); ?></td>
                                        <td>📞 <?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td><span class="badge bg-success">Available</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="alert alert-danger text-center fw-bold fs-5 shadow-sm">
                        ❌ Sorry, <?php echo htmlspecialchars($searched_group); ?> Blood Group is CURRENTLY NOT AVAILABLE.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>