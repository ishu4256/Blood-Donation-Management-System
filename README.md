# 🩸 Blood Donation Management System

A secure and user-friendly Blood Donation Management System built with PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap to connect donors, hospitals, and patients.

## 🚀 Features

* **Smart Blood Search:** Real-time lookup system allowing users to search for active and available blood donors.
* **Secure Authentication:** Complete and secure user management system including account creation, login, password reset, and OTP verification.
* **Responsive Dashboard:** A clean, centralized dashboard for easy navigation between different sections of the application.
* **Donor & Patient Management:** Form portals to handle new account registration and donor tracking.
* **Hospital & Campaign Directory:** Easily manage and view interconnected hospital networks and upcoming blood donation campaigns.

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3, JavaScript (ES6), Bootstrap 5
* **Backend:** PHP
* **Database:** MySQL (via XAMPP)

## 📁 Key File Structure

Based on the repository layout, here is how the core files function:

* `Dashboard.php` - The main user interface and navigation center.
* `check_blood.php` - Core module to query and display available blood groups from the database.
* `hospital.php` - Directory listing active partner hospitals across provinces.
* `campaign.php` - Panel displaying information about current and upcoming blood donation campaigns.
* `donor.php` - Overview portal managing donor records and their registration status.
* `evnts.php` & `publication.php` - Sections handling news, scheduled events, and healthcare documents.
* `contact.php` & `about.php` - Contact support gateways and platform description modules.
* `feedback.php` - User feedback submission and processing.
* `New Account1.php` & `New Account2.php` - Step-by-step registration portal for new users/donors.
* `ForgetPassword.php`, `ResetPassword.php`, `NEWPASSWORD.PHP` - Full password recovery workflow.
* `VerifyOTP.php` - One-Time Password (OTP) verification screen for enhanced security.
* `/images` & `/uploads` - Directories for static assets and user-uploaded media.
* `/vendor` - Dependency folder for external libraries or plugins.

## 🔧 Installation & Local Setup

### Prerequisites:
* XAMPP Server installed on your local machine.
* PHP 8.0 or higher.

### Step-by-Step Setup:
1. **Clone the Repository:**
   ```bash
  1 Move to XAMPP Root:
Place the extracted project folder into your C:/xampp/htdocs/ directory.

  2 Database Configuration:

Open phpMyAdmin (http://localhost/phpmyadmin).

Create a database named blood_donations.

Import your project's .sql file into the database.

  3 Run the Project:
Start Apache and MySQL modules from the XAMPP Control Panel and visit:

Plaintext
http://localhost/Blood-Donation-Management-System/Dashboard.php

📝 License
This project is open-source and managed under the MIT License.
   git clone [https://github.com/ishu4256/Blood-Donation-Management-System.git](https://github.com/ishu4256/Blood-Donation-Management-System.git)
