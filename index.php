<!DOCTYPE html>
<html >
<head>
    
    <title>Volunteer Program</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            margin:0;
            padding:0;
        }

        /* Top Bar */
        .top-bar{
            background:#8e0000;
            padding:10px 30px;
            text-align:right;
        }
        .top-bara{
            text-align:center;
        }

        /* Hero Section */
        .hero{
            background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)),
            url('images/pic1.jpg');
            background-size:cover;
            background-position:center;
            color:white;
            padding:80px 20px;
            text-align:center;
        }

        .hero h1{
            font-size:60px;
            font-weight:bold;
        }

        .hero p{
            font-size:25px;
        }

        /* Navigation */
        .nav-buttons .btn{
            margin:8px;
            font-weight:bold;
        }

        /* Main Section */
        .main-section{
            padding:50px 20px;
        }

        .image-box img{
            width:100%;
            border-radius:10px;
            box-shadow:0 0 10px gray;
        }

      
        /* News Box */
        .news-box{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px gray;
        }

        .news-box h3{
            color:#c0392b;
            margin-bottom:20px;
        }

        .news-box ul li{
            margin-bottom:15px;
            font-size:18px;
        }

        /* Features */
        .features{
            background:white;
            padding:50px 20px;
        }

        .feature-card{
            text-align:center;
            padding:25px;
            background:#fff;
            border-radius:10px;
            box-shadow:0 0 10px #ddd;
            height:100%;
        }

        .feature-card i{
            font-size:40px;
            color:#c0392b;
            margin-bottom:15px;
        }

        /* Paragraph Section */
        .info-section{
            padding:50px;
            background:#fdecea;
            text-align:center;
        }

        /* Mission Vision */
        .mv-section{
            padding:50px 20px;
            background:white;
        }

        .mv-card{
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px #ddd;
            height:100%;
        }

        .mv-card h3{
            color:#c0392b;
        }

        /* Footer */
        footer{
            background:#8e0000;
            color:white;
            padding:40px 20px;
        }

        footer h4{
            margin-bottom:20px;
        }

        footer a{
            color:white;
            text-decoration:none;
            display:block;
            margin-bottom:10px;
        }

        footer a:hover{
            text-decoration:underline;
        }

        .hero-section { border: 1px solid #ddd; padding: 30px; border-radius: 8px; max-width: 500px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        /* Join Now Button එක */
        .btn-join { background-color: #28a745; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; font-weight: bold; }
        .btn-join:hover { background-color: #218838; }

        /* Background එක අඳුරු කරන කොටස (Modal Overlay) */
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; }

        /* මැදින් එන Popup Box එක (Modal Content) */
        .modal-content { background-color: white; padding: 25px; border-radius: 10px; width: 100%; max-width: 450px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); animation: fadeIn 0.3s ease-in-out; position: relative; }

        /* Popup එක Close කරන (X) ලකුණ */
        .close-btn { position: absolute; right: 20px; top: 15px; font-size: 28px; font-weight: bold; color: #aaa; cursor: pointer; }
        .close-btn:hover { color: black; }

        /* Form එක ඇතුලේ Styling */
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input[type="text"], input[type="email"], input[type="tel"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { background-color: #007bff; color: white; padding: 12px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; font-weight: bold; }
        .btn-submit:hover { background-color: #0069d9; }

        /* Popup එක ලස්සනට පාවෙලා එන්න Animation එකක් */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>

<body>

<!-- Top Bar -->
<div class="top-bar">
    <a href="login.php" class="btn btn-light" >Log Out</a>
<div class="top-bara">
    <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:200px; height:200px; object-fit:cover; border-radius:50%;">
</div>
</div>

<!-- Hero Section -->
<div class="hero">

    <div class="nav-buttons">
                <a href="Dashboard.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">Dashboard</a>

        <a href="Services.php" class="btn btn-light">Services</a>
        <a href="donor.php" class="btn btn-light">Donors</a>
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-light">More</a>
    </div>

    <hr>

    
    <br><br><br><h1>
     <a href="donor_rejiststion.php" class="btn btn-light"> Registation as a Donor</a>
</h1>

</div>

<center>
<div class="hero-section">
        <h2>Volunteer Program</h2>
        <p>Join our volunteer community and help organize donation events.</p>
        <button class="btn-join" onclick="openModal()">Join Now</button>
    </div>

    <div id="volunteerModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            
            <h3>Volunteer Registration</h3>
            <hr><br>
            
            <form action="join.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name (සම්පූර්ණ නම):</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address (ඊමේල්):</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number (දුරකථන අංකය):</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="area">Preferred Area to Help (ක්ෂේත්‍රය):</label>
                    <select id="area" name="area">
                        <option value="Event Organizing">Event Organizing (සංවිධාන කටයුතු)</option>
                        <option value="Logistics/Transport">Logistics/Transport (ප්‍රවාහන කටයුතු)</option>
                        <option value="Marketing/Promo">Marketing/Social Media</option>
                        <option value="Any">Any (ඕනෑම වැඩකටයුත්තක්)</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Submit Application</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("volunteerModal");

        // Popup එක පෙන්වන්න
        function openModal() {
            modal.style.display = "flex";
        }

        // Popup එක වහන්න
        function closeModal() {
            modal.style.display = "none";
        }

        // Popup එකෙන් පිටත කළු පාට Area එක ක්ලික් කරත් Popup එක වැහෙනවා
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</center>

<!-- Mission & Vision -->
<div class="mv-section">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Vision</h3>
                    <p>
                        To create a healthier Sri Lanka where safe blood is available
                        for everyone, anytime, anywhere.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mv-card">
                    <h3>Our Mission</h3>
                    <p>
                        To build a reliable blood donation network through technology,
                        awareness, and compassionate community support.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h4>About Us</h4>
                <p>
                    Online Blood Donation System Sri Lanka helps connect blood donors
                    and recipients efficiently to save lives.
                </p>
            </div>

            <div class="col-md-4">
                <h4>Quick Links</h4>
                <a href="Services.php">Services</a>
                <a href="donor.php">Donors</a>
                <a href="evnts.php">Events & News</a>
                <a href="contact.php">Contact Us</a>
            </div>

            <div class="col-md-4">
               <h4>Contact</h4>

<p>Email: sandarekaishani83@gmail.com</p>

<p>Phone: +94782314518</p>

</div>
            </div>

        </div>
    </div>
</footer>

</body>
</html>