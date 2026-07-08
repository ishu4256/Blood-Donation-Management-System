<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>More Services</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}


.partner-modal-content{
    max-width:1000px;
    width:95%;
    max-height:90vh;
    overflow-y:auto;
}

.list-group-item{
    flex-direction:column;
    align-items:flex-start !important;
}

.list-group-item span{
    margin-top:5px;
}

.list-group-item p{
    margin-top:5px;
    margin-bottom:0;
}
.top-bar{
    background:#8e0000;
    padding:10px 30px;
    text-align:right;
}

.top-bara{
    text-align:center;
}

.hero{
    background:linear-gradient(rgba(192,57,43,0.9), rgba(192,57,43,0.9)),
    url('images/pic1.jpg');

    background-size:cover;
    color:white;
    text-align:center;
    padding:80px 20px;
}

.nav-buttons .btn{
    margin:8px;
}

.more-card{
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 10px #ccc;
    height:100%;
    text-align:center;
}

.more-card h4{
    color:#c0392b;
}

.info-box{
    background:#fdecea;
    padding:40px;
    border-radius:15px;
    text-align:center;
}

footer{
    background:#8e0000;
    color:white;
    padding:40px 20px;
    margin-top:50px;
}

/* --- POPUP (MODAL) CSS කොටස --- */
.custom-modal {
    display: none; 
    position: fixed; 
    z-index: 1050; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0,0,0,0.6); 
    justify-content: center; 
    align-items: center; 
}

.custom-modal-content { 
    background-color: white; 
    padding: 25px; 
    border-radius: 15px; 
    width: 100%; 
    max-width: 450px; 
    box-shadow: 0 5px 15px rgba(0,0,0,0.3); 
    animation: fadeIn 0.3s ease-in-out; 
    position: relative; 
    text-align: left;
}

.custom-close-btn { 
    position: absolute; 
    right: 20px; 
    top: 15px; 
    font-size: 28px; 
    font-weight: bold; 
    color: #aaa; 
    cursor: pointer; 
}

.custom-close-btn:hover { color: black; }

.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; color: #333; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
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

<a href="donor.php" class="btn btn-light">Donors</a>

<a href="evnts.php" class="btn btn-light">Events & News</a>

<a href="publication.php" class="btn btn-light">Publications</a>

<a href="contact.php" class="btn btn-light">Contact Us</a>

<a href="about.php" class="btn btn-light">About Us</a>

<a href="more.php"
class="btn btn-warning fw-bold text-dark border border-3 border-light shadow">
More
</a>
<br><br>
<center>
<div class="nav-buttons">

<button class="btn btn-light"
onclick="window.open('hospital.php','Hospitals','width=900,height=600')">
    Hospitals
</button>

<button class="btn btn-light"
onclick="window.open('check_blood.php','BloodStock','width=900,height=600')">
    Blood Stock
</button>


<button class="btn btn-light"
onclick="window.open('campaign.php','Campaign','width=900,height=600')">
    campaigns
</button>
</div>

<button class="btn btn-light"
onclick="window.open('feedback.php','Feedback','width=900,height=600')">
    Feedback
</button>
</div>
</center>


<a href="donor_rejiststion.php" class="btn btn-light btn-lg">

Register as a Donor

</a>
</div>

<hr>

<h1 class="mt-5">More Blood Donation Services</h1>

<p>
Additional services and important health information
</p>

</div>
<br><br><br>
<div>

<center>
<img src="images/static report.jpeg">
<a href="images/Stat-Annual-Report-2024.pdf" target="_blank"><br>
    <button> view Stat-Annual-Report-2024</button>
</a>
<br><br><br>
<br><br><br>
<img src="images/static report1.jpeg">
<a href="images/Stat-Annual-Report-2023.pdf" target="_blank"><br>
    <button>view Stat-Annual-Report-2023</button>
</a></center>
<div class="container py-5">

<div class="row g-4">

<div class="col-md-4">

<div class="more-card">

<h4>Blood Compatibility</h4>

<p>
Learn which blood groups can donate and receive safely.
</p>

<a href="images/blood_transfusion_compatibility_guide.pdf" class="btn btn-danger">
Read More
</a>

</div>

</div>
<div id="partnerModal" class="custom-modal">
   <div class="custom-modal-content partner-modal-content"> <span class="custom-close-btn" onclick="closePartnerModal()">&times;</span>
<br>
        <h3 style="color:#c0392b;">Our Hospital Partners</h3>
        <p style="font-size:13px; color:#666;">Islandwide interconnected blood banks.</p>
        <hr>
        <br>
<br>

<h1>Operational Headquarters</h1>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>National Blood Center</b><br><small class="text-muted">No. 555/5D, Elvitigala Mawatha, Narahenpita, Colombo 05</small></div>
                <span class="text-danger fw-bold">+94 11 236 9931 / +94 11 236 9932 / +94 11 236 9933</span><br>
                <p>Donation Hours: 8:00 AM – 6:00 PM (Daily)</p>
            </li>
<br>
<br>


            <h1>Western Province</h1>

  <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Colombo North Teaching Hospital Blood Bank</b><br><small class="text-muted">Teaching Hospital, Ragama</small></div>
                <span class="text-danger fw-bold">+94 11 296 0535 / +94 11 295 9261</span><br>
               
            </li>
<br>


  <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Apeksha Hospital</b><br><small class="text-muted">National Cancer Institute, Maharagama</small></div>
                <span class="text-danger fw-bold"> +94 11 284 9525 / +94 11 289 7377</span><br>
               
            </li>
<br>

              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Regional Blood Centre</b><br><small class="text-muted">District General Hospital, Kalutara</small></div>
                <span class="text-danger fw-bold">  +94 034 222 2261 / +94 034 223 6529</span><br>
               
            </li>

<br>
<br>

            <h1>Central & Strategic Regional Provinces</h1>
<br>


            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>General Hospital Kandy</b><br><small class="text-muted">National Hospital,Kandy</small></div>
                <span class="text-danger fw-bold">+94 081 220 3100 / +94 081 222 2261</span>
            </li>
<br>

 <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Kurunegala Regional Blood Centre</b><br><small class="text-muted">Teaching Hospital, Kurunegala</small></div>
                <span class="text-danger fw-bold">+94 037 222 9617 / +94 037 222 3873</span>
            </li>

<br>

 <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Anuradhapura Regional Blood Centre</b><br><small class="text-muted"> Teaching Hospital, Anuradhapura</small></div>
                <span class="text-danger fw-bold">+94 025 222 2261 / +94 025 223 6424</span>
            </li>
<br>
<br>



                        <h1>Southern, Eastern & Northern Provinces</h1>

<br>


            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Karapitiya Hospital</b><br><small class="text-muted"> Karapitiya Teaching Hospital, Galle</small></div>
                <span class="text-danger fw-bold">+94 091 222 6066 / +94 091 223 2267</span>
            </li>
<br>



 <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Regional Blood Centre -Jaffna (Blood Bank)</b><br><small class="text-muted"> Teaching Hospital, Jaffna</small></div>
                <span class="text-danger fw-bold">+94 021 222 3063 / +94 021 222 2261</span>
            </li>

<br>

             <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>District General Hospital Trincomalee | ත්‍රිකුණාමලය දිස්ත්‍රික් මහ රෝහල | திருக்கோணமலை மாவட்ட பொது</b><br><small class="text-muted">  District General Hospital, Trincomalee</small></div>
                <span class="text-danger fw-bold">+94 026 223 1385 / +94 026 222 2600</span>
            </li>
<br>


             <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Badulla Regional Blood Centre</b><br><small class="text-muted">  Provincial General Hospital, Badulla</small></div>
                <span class="text-danger fw-bold"> +94 055 222 2124 / +94 055 222 2261</span>
            </li>
<br>


             <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>District General Hospital - Hambantota(New) | දිස්ත්‍රික් මහ රෝහල - හම්බන්තොට</b><br><small class="text-muted">   District General Hospital, Hambantota</small></div>
                <span class="text-danger fw-bold">  +94 047 222 2016 / +94 047 222 0261</span>
            </li>
<br>

             <li class="list-group-item d-flex justify-content-between align-items-center">
                <div><b>Teaching Hospital - Ratnapura</b><br><small class="text-muted">   Provincial General Hospital, Ratnapura</small></div>
                <span class="text-danger fw-bold"> +94 045 222 6592 / +94 045 222 2600</span>
            </li>


<br>







        </ul>
        <button class="btn btn-secondary w-100 mt-3" onclick="closePartnerModal()">Close</button>
    </div>
</div>
<div class="col-md-4">

<div class="more-card">

<h4>Volunteer Program</h4>

<p>
Join our volunteer community and help organize donation events.
</p>

<button onclick="openVolunteerModal()" class="btn btn-danger">
Join Now
</button>

</div>

</div>

<div class="col-md-4">

<div class="more-card">

<h4>Hospital Partnerships</h4>

<p>
We work with hospitals islandwide for emergency blood supply.
</p>

<button onclick="openPartnerModal()" class="btn btn-danger">View Partners</button>

</div>

</div>

</div>

<div class="info-box mt-5">

<h2 class="text-danger">
Did You Know?
</h2>

<p>
One blood donation can save up to 3 lives.
Blood donation improves blood circulation and helps patients during emergencies.
</p>

</div>

<div class="row mt-5 g-4">

<div class="col-md-6">

<div class="more-card">

<h4>Useful Links</h4>

<a href="https://health.gov.lk" target="_blank" class="btn btn-outline-danger m-2">
Ministry of Health
</a>

<a href="https://nbts.health.gov.lk" target="_blank" class="btn btn-outline-danger m-2">
National Blood Transfusion Service
</a>

</div>

</div>

<div class="col-md-6">

<div class="more-card">

<h4>Emergency Contacts</h4>

<p>🚑 National Blood Centre - 011 533 6666</p>

<p>🚑 Emergency Hotline - 1990</p>

<p>🚑 Suwa Seriya Ambulance Service</p>

</div>

</div>

</div>

</div>

<div id="volunteerModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close-btn" onclick="closeVolunteerModal()">&times;</span>
        
        <h3 style="color:#c0392b;">Volunteer Registration</h3>
        <p style="font-size:13px; color:#666;">Fill this form to join our community.</p>
        <hr>
        
        <form action="join.php" method="POST">
            <div class="form-group">
                <label>Full Name (සම්පූර්ණ නම):</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email Address (ඊමේල්):</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone Number (දුරකථන අංකය):</label>
                <input type="tel" name="phone" required>
            </div>

            <div class="form-group">
                <label>Preferred Area (උදව් කළ හැකි ක්ෂේත්‍රය):</label>
                <select name="area">
                    <option value="Event Organizing">Event Organizing (සංවිධාන කටයුතු)</option>
                    <option value="Logistics/Transport">Logistics/Transport (ප්‍රවාහන)</option>
                    <option value="Marketing/Promo">Marketing / Social Media</option>
                    <option value="Any">Any (ඕනෑම වැඩකටයුත්තක්)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-danger w-100 mt-2 fw-bold">Submit Application</button>
        </form>
    </div>
</div>

<footer>

<div class="container">

<div class="row">

<div class="col-md-4">

<h4>About Us</h4>

<p>
Online Blood Donation System Sri Lanka helps connect donors and recipients.
</p>



</div>

<div class="col-md-4">

<h4>Quick Links</h4>

<a href="Services.php" class="text-white d-block">Services</a>

<a href="donor.php" class="text-white d-block">Donors</a>

<a href="evnts.php" class="text-white d-block">Events</a>

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

<script>
var modal = document.getElementById("volunteerModal");

function openVolunteerModal() {
    modal.style.display = "flex";
}

function closeVolunteerModal() {
    modal.style.display = "none";
}

// Popup එකෙන් පිටත කළු පාට පසුබිම ක්ලික් කරොත් වැහෙනවා
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


var partnerModal = document.getElementById("partnerModal");

function openPartnerModal() {
    partnerModal.style.display = "flex";
}

function closePartnerModal() {
    partnerModal.style.display = "none";
}

// කලින් තිබුන window.onclick එක මේ විදිහට Update කරන්න (Popup දෙකම වැහෙන්න)
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == partnerModal) {
        partnerModal.style.display = "none";
    }
}


var modal = document.getElementById("volunteerModal");
var partnerModal = document.getElementById("partnerModal");

function openVolunteerModal() {
    modal.style.display = "flex";
}

function closeVolunteerModal() {
    modal.style.display = "none";
}

function openPartnerModal() {
    partnerModal.style.display = "flex";
}

function closePartnerModal() {
    partnerModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }

    if (event.target == partnerModal) {
        partnerModal.style.display = "none";
    }
}
</script>

</body>
</html>