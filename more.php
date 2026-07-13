<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More Services</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body{ font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
        .top-bar{ background:#8e0000; padding:10px 30px; text-align:right; }
        .top-bara{ text-align:center; }
        .hero{
            background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)), url('images/pic1.jpg');
            background-size:cover; background-position:center; color:white; padding:80px 20px; text-align:center;
        }
        .hero h1{ font-size:60px; font-weight:bold; }
        .nav-buttons .btn{ margin:8px; font-weight:bold; }
        
        /* SUB NAVIGATION BUTTONS */
        .sub-nav .btn {
            background: #f1e7e7f0 !important;
            color: black !important;
            border: 1px solid #e2584a !important;
            font-weight: normal;
            font-size: 12px;
            padding: 5px 12px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .sub-nav .btn:hover {
            background: #e2584a !important;
        }

        .reg-btn {
            background: white;
            color: black;
            font-weight: 500;
            padding: 8px 24px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 13px;
        }

        /* Content Sections */
        .more-card {
            background: white;
            padding: 30px 25px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            height: 100%;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.03);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .more-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }
        .more-card h4 {
            color: #c0392b;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .report-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: none;
        }
        .report-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .info-box {
            background: #fff5f5;
            padding: 35px;
            border-radius: 16px;
            text-align: center;
            border-left: 5px solid #dc3545;
        }
        
        /* Footer Styling */
         footer{ background:#8e0000; color:white; padding:40px 20px; }
        footer a{ color:white; text-decoration:none; display:block; margin-bottom:10px; }
        footer a:hover{ text-decoration:underline; }
        
        /* Hospital Group styling in Modal */
        .hospital-group-title {
            background: #f8d7da;
            color: #721c24;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 1.05rem;
            font-weight: bold;
            margin-top: 25px;
            border-left: 4px solid #dc3545;
        }
        .hospital-item {
            border: 1px solid #eaeaea !important;
            border-radius: 8px !important;
            margin-bottom: 8px;
            background: #fafafa;
            padding: 12px 15px !important;
        }
    </style>
</head>
<body>


<div class="top-bar d-flex align-items-center justify-content-between flex-wrap">
    <div class="text-start order-1">
        <a href="profile.php" class="btn btn-light btn-sm fw-bold shadow-sm px-3">👤 Profile</a>
    </div>    
    <div class="top-bara order-2 my-2">
        <img src="images/logo.png" alt="Blood Donation" class="img-fluid rounded shadow" style="width:120px; height:120px; object-fit:cover;">
    </div>
    <div class="text-end order-3">
        <a href="login.php" class="btn btn-light btn-sm fw-bold shadow-sm px-3">Log Out</a>
    </div>  
</div>

<div class="hero">
    <div class="nav-buttons">
        <a href="Dashboard.php" class="btn btn-light">Dashboard</a>
        <a href="Services.php" class="btn btn-light">Services</a>
        <a href="donor.php" class="btn btn-light ">Donor</a>  
        <a href="evnts.php" class="btn btn-light">Events & News</a>
        <a href="publication.php" class="btn btn-light">Publications</a>
        <a href="contact.php" class="btn btn-light">Contact Us</a>
        <a href="about.php" class="btn btn-light">About Us</a>
        <a href="more.php" class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">More</a>
    </div>
    <hr>
    <!-- Sub Shortcuts Links -->
        <div class="nav-buttons sub-nav mt-3 justify-content-center d-flex flex-wrap">
            <button class="btn btn-sm mx-1" onclick="window.open('hospital.php','Hospitals','width=900,height=600')">🏥 Hospitals</button>
            <button class="btn btn-sm mx-1" onclick="window.open('check_blood.php','BloodStock','width=900,height=600')">🩸 Blood Stock</button>
            <button class="btn btn-sm mx-1" onclick="window.open('campaign.php','Campaign','width=900,height=600')">📢 Campaigns</button>
            <button class="btn btn-sm mx-1" onclick="window.open('feedback.php','Feedback','width=900,height=600')">⭐ Feedback</button>
        </div>
        <br><br>
    <h1>
        <a href="donor_rejiststion.php" class="btn btn-light btn-lg fw-bold text-danger shadow-sm">Registration as a Donor</a>
    </h1>
        
    </div>
    </div>

</div>

<!-- MAIN CONTENT CONTAINER -->
<div class="container py-5">
    
    <!-- ANNUAL REPORTS SECTION -->
    <h3 class="text-center fw-bold mb-4 text-secondary">Annual Statistical Reports</h3>
    <div class="row g-4 justify-content-center mb-5">
        <div class="col-md-5 col-lg-4">
            <div class="card report-card text-center">
                <img src="images/static report.jpeg" alt="Report 2024" onerror="this.src='https://placehold.co/400x250?text=Report+Image'">
                <div class="card-body">
                    <a href="images/Stat-Annual-Report-2024.pdf" target="_blank" class="btn btn-outline-danger btn-sm w-100 fw-bold py-2">
                        📄 View Annual Report 2024
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div class="card report-card text-center">
                <img src="images/static report1.jpeg" alt="Report 2023" onerror="this.src='https://placehold.co/400x250?text=Report+Image'">
                <div class="card-body">
                    <a href="images/Stat-Annual-Report-2023.pdf" target="_blank" class="btn btn-outline-danger btn-sm w-100 fw-bold py-2">
                        📄 View Annual Report 2023
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CORE FEATURE CARDS -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="more-card">
                <h4>Blood Compatibility</h4>
                <p class="text-muted small">Learn which blood groups can donate and receive safely during emergencies.</p>
                <a href="images/blood_transfusion_compatibility_guide.pdf" target="_blank" class="btn btn-danger btn-sm w-100 mt-2">
                    Read Guide
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="more-card">
                <h4>Volunteer Program</h4>
                <p class="text-muted small">Join our volunteer community and help organize islandwide donation events.</p>
                <button class="btn btn-danger btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#volunteerModal">
                    Join Now
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="more-card">
                <h4>Hospital Partnerships</h4>
                <p class="text-muted small">We work closely with major hospitals islandwide for continuous emergency blood supply.</p>
                <button class="btn btn-danger btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#partnerModal">
                    View Partners
                </button>
            </div>
        </div>
    </div>

    <!-- HEALTH INFO BOX -->
    <div class="info-box mt-5 shadow-sm">
        <h3 class="text-danger fw-bold mb-2">Did You Know?</h3>
        <p class="mb-0 fs-5">
            One single blood donation can save up to <b>3 lives</b>. Regular donation improves blood circulation and overall cardiovascular health.
        </p>
    </div>

    <!-- CONTACTS & LINKS -->
    <div class="row mt-5 g-4">
        <div class="col-md-6">
            <div class="more-card text-start">
                <h4 class="text-center">Useful Links</h4>
                <div class="d-grid gap-2 mt-3">
                    <a href="https://health.gov.lk" target="_blank" class="btn btn-outline-secondary btn-sm text-start">
                        🔗 Ministry of Health Sri Lanka
                    </a>
                    <a href="https://nbts.health.gov.lk" target="_blank" class="btn btn-outline-secondary btn-sm text-start">
                        🔗 National Blood Transfusion Service
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="more-card text-start">
                <h4 class="text-center">Emergency Contacts</h4>
                <div class="mt-3 ps-2 small">
                    <p class="mb-2"><strong>🚑 National Blood Centre:</strong> <span class="text-danger fw-bold">011 533 6666</span></p>
                    <p class="mb-2"><strong>🚑 Emergency Hotline:</strong> <span class="text-danger fw-bold">1990</span> (Suwa Seriya Ambulance Service)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODALS SECTION ================= -->

<!-- 1. VOLUNTEER REGISTRATION MODAL -->
<div class="modal fade" id="volunteerModal" tabindex="-1" aria-labelledby="volunteerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="volunteerModalLabel">Volunteer Registration</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="join.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Full Name (සම්පූර්ණ නම)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address (ඊමේල්)</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Phone Number (දුරකථන අංකය)</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Area / District (දිස්ත්‍රික්කය)</label>
                        <select name="area" class="form-select" required>
                            <option value="" disabled selected>Select District</option>
                            <option value="Colombo">Colombo</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Matale">Matale</option>
                            <option value="Nuwara Eliya">Nuwara Eliya</option>
                            <option value="Galle">Galle</option>
                            <option value="Matara">Matara</option>
                            <option value="Hambantota">Hambantota</option>
                            <option value="Jaffna">Jaffna</option>
                            <option value="Kurunegala">Kurunegala</option>
                            <option value="Anuradhapura">Anuradhapura</option>
                            <option value="Ratnapura">Ratnapura</option>
                            <option value="Kegalle">Kegalle</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2 rounded shadow-sm">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. HOSPITAL PARTNERS MODAL  -->
<div class="modal fade" id="partnerModal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="partnerModalLabel">Our Hospital Partners</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Western Province -->
                <div class="hospital-group-title mt-0">Western Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">National Blood Transfusion Service (Central Blood Bank)</h6>
                            <small class="text-muted">Asiri Kemadasa Mawatha, Colombo 05 (Colombo District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0112369931</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">National Hospital of Sri Lanka (NHSL)</h6>
                            <small class="text-muted">Colombo 10 (Colombo District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0112691111</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Colombo South Teaching Hospital</h6>
                            <small class="text-muted">Kalubowila (Colombo District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0112822261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Colombo North Teaching Hospital</h6>
                            <small class="text-muted">Ragama (Gampaha District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0112959201</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Gampaha</h6>
                            <small class="text-muted">Gampaha (Gampaha District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0332222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Kalutara</h6>
                            <small class="text-muted">Nagoda, Kalutara (Kalutara District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0342222261</span>
                    </div>
                </div>

                <!-- Southern Province -->
                <div class="hospital-group-title">Southern Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Teaching Hospital - Karapitiya</h6>
                            <small class="text-muted">Karapitiya, Galle (Galle District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0912232250</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Matara</h6>
                            <small class="text-muted">Matara (Matara District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0412222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Hambantota</h6>
                            <small class="text-muted">Hambantota (Hambantota District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0472220183</span>
                    </div>
                </div>

                <!-- Central Province -->
                <div class="hospital-group-title">Central Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">National Hospital - Kandy</h6>
                            <small class="text-muted">Kandy (Kandy District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0812233337</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Matale</h6>
                            <small class="text-muted">Matale (Matale District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0662222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Nuwara Eliya</h6>
                            <small class="text-muted">Nuwara Eliya (Nuwara Eliya District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0522222261</span>
                    </div>
                </div>

                <!-- North Central Province -->
                <div class="hospital-group-title">North Central Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Teaching Hospital - Anuradhapura</h6>
                            <small class="text-muted">Anuradhapura (Anuradhapura District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0252222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Polonnaruwa</h6>
                            <small class="text-muted">Polonnaruwa (Polonnaruwa District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0272222261</span>
                    </div>
                </div>

                <!-- North Western Province -->
                <div class="hospital-group-title">North Western Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Teaching Hospital - Kurunegala</h6>
                            <small class="text-muted">Kurunegala (Kurunegala District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0372222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Chilaw</h6>
                            <small class="text-muted">Chilaw (Puttalam District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0322222261</span>
                    </div>
                </div>

                <!-- Sabaragamuwa Province -->
                <div class="hospital-group-title">Sabaragamuwa Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Provincial General Hospital - Ratnapura</h6>
                            <small class="text-muted">Ratnapura (Ratnapura District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0452222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Kegalle</h6>
                            <small class="text-muted">Kegalle (Kegalle District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0352222261</span>
                    </div>
                </div>

                <!-- Uva Province -->
                <div class="hospital-group-title">Uva Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Provincial General Hospital - Badulla</h6>
                            <small class="text-muted">Badulla (Badulla District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0552222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Monaragala</h6>
                            <small class="text-muted">Monaragala (Monaragala District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0552273261</span>
                    </div>
                </div>

                <!-- Northern Province -->
                <div class="hospital-group-title">Northern Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Teaching Hospital - Jaffna</h6>
                            <small class="text-muted">Jaffna (Jaffna District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0212222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Vavuniya</h6>
                            <small class="text-muted">Vavuniya (Vavuniya District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0242222261</span>
                    </div>
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">District General Hospital - Mannar</h6>
                            <small class="text-muted">Mannar (Mannar District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0232222261</span>
                    </div>
                </div>

                <!-- Eastern Province -->
                <div class="hospital-group-title">Eastern Province</div>
                <div class="list-group list-group-flush mt-2">
                    <div class="list-group-item hospital-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Teaching Hospital - Batticaloa</h6>
                            <small class="text-muted">Batticaloa (Batticaloa District)</small>
                        </div>
                        <span class="badge bg-outline-danger border text-danger">0652222261</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>About Us</h4>
                <p>Online Blood Donation System Sri Lanka helps connect blood donors and recipients efficiently to save lives.</p>
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
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>