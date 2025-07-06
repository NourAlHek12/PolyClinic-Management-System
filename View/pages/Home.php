<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
<?php include '../../Controller/specialityController.php'; ?>
<?php include '../../Controller/roomController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="shortcut icon" href="../images/icons8-clinic-16.png" type="image/icon">
    <title>Polyclinic</title>
    <style>
        
    </style>

</head>

<body>
    <?php include '../components/header.php'; ?>
    <?php
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user'] != "manager" && $_SESSION['user'] != "secretary" && $_SESSION['user'] != "doctor")):
    ?>
    <?php if(!isset($_SESSION['user'])){
        include '../components/guest/banner.php';
    } else if(isset($_SESSION['user']) && $_SESSION['user'] === "patient"){
        include '../components/patient/banner.php';
    }
    ?>
    <!-- About Us -->
    <div id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-4 py-md-0">
                    <div class="card">
                        <img src="../images/dr1.jpeg" alt="">
                    </div>
                </div>
                <div class="col-md-8 py-3 py-md-0">
                    <h3>About Us</h3>
                    <p>We operate as a team of medical professionals within a polyclinic, offering appointment scheduling services through our
                         online platform. Furthermore, your health records are meticulously
                         maintained within our secure database, accessible exclusively to authorized personnel within the medical team
                    </p>
                    <h2 style="color:darkblue">Name: <span style="color:#fff">Polyclinic</span></h2>
                    <h2 style="color:darkblue">Year Created: <span style="color:#fff">2024</span></h2>
                    <h2 style="color:darkblue">Located in: <span style="color:#fff">Lebanon-Rayak</span></h2>
                    <h2 style="color:darkblue">Email:<span style="color:#fff">PolyClinicManagement@gmail.com</span></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us End -->
    <div>
        <iframe id="location"
               src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Lebanon+bekaa+Riyaq+liu"
               width="600" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe
        >    
    </div>
    <!-- Services -->
    <div id="services">
        <div class="container">
            <h2  style="color:black">Services</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="feature col" id="card">
                    <i class="fa-solid fa-calendar-days" style="color: darkblue;"></i>
                    <h3  style="color:black">Take Appointment</h3>
                    <p  style="color:black">As a pateint, this website services you to schedule an online appointment, instead to go physically
                        to the clinic and take a lot of time
                        Click on the button in the top of the page or click on the patient section, register, login then
                        take your  appintment through this link: <a href="./patientLogin.php">Click Here</a>.</p>
                </div>
                <div class="feature col" id="card">
                    <i class="fa-solid fa-file-medical" style="color: darkblue;"></i>
                    <h3  style="color:black">Patient History</h3>
                    <p  style="color:black">As a healthcare professional, rather than relying on cumbersome paper 
                    records and facing concerns about potential data loss, this platform offers the capability to securely input and 
                    store all patient medical data within a dedicated database. <br>if you are a doctor open your own web-page through this link:<a href="./doctorLogin.php">Login</a> </p>
                </div>
                <div class="feature col" id="card">
                    <i class="fa-solid fa-list-check" style="color: darkblue;"></i>
                    <h3  style="color:black">Management</h3>
                    <p  style="color:black">In the capacity of a website administrator or a doctor's secretary, key
                     responsibilities entail managing various aspects including the addition and removal of doctors, 
                     scheduling appointments, cancellation of appointments, and computing the daily fees accrued by each doctor etc....<br>Login as administrator through this link:  <a href="./otherLogin.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->
    <?php endif; ?>
    <?php 
    if(isset($_SESSION['user']) && $_SESSION['user'] == "manager") : 
    ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <h1 class="alert alert-info">Hello Manager</h1>
        <div class="row mb-5">
            <div class="col">
                <a href="home.php?section=doctor" class="btn btn-primary">Doctors</a>
                <a href="home.php?section=secretary" class="btn btn-primary">Secretaries</a>
                <a href="home.php?section=speciality" class="btn btn-primary">Specialties</a>
                <a href="home.php?section=room" class="btn btn-primary">Rooms</a>
            </div>
        </div>
    </div>
        <?php
        // Check if the "section" parameter is not set in the URL
        if (!isset($_GET['section'])) {
            // Redirect the user to the "doctor" section
            header('Location: home.php?section=doctor');
            exit; // Ensure that no further code is executed after the redirect
        }
        ?>
        <?php include '../../Controller/doctorController.php';?>
        <?php include '../../Controller/secretaryController.php';?>
        <?php if($_GET['section'] === "doctor"): ?>
            <?php include '../components/manager/doctorSection.php'; ?>
        <?php elseif($_GET['section'] === "secretary") : ?>
            <?php include '../components/manager/secretaryrSection.php'; ?>
        <?php elseif($_GET['section'] === "speciality") : ?>
            <?php include '../components/manager/specialitySection.php'; ?>
        <?php elseif($_GET['section'] === "room") : ?>
            <?php include '../components/manager/roomSection.php'; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php 
    if(isset($_SESSION['user']) && $_SESSION['user'] == "secretary") : 
    ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <h1 class="alert alert-info">Hello Secretary, <?=$_SESSION['name']?></h1>
        <div class="row mb-5">
            <div class="col">
            <a href="home.php?section=doctor" class="btn btn-primary">Doctors</a>
            <a href="home.php?section=bookedApp" class="btn btn-primary">Booked Appointments </a>
            <a href="home.php?section=acceptedApp" class="btn btn-primary">Accepted Appointments </a>
            <a href="home.php?section=print" class="btn btn-primary">Print Fees</a>
            <a href="home.php?section=pass" class="btn btn-primary">Change Password </a>
            </div>
        </div>
    </div>
        <?php
        // Check if the "section" parameter is not set in the URL
        if (!isset($_GET['section'])) {
            // Redirect the user to the "doctor" section
            header('Location: home.php?section=doctor');
            exit; // Ensure that no further code is executed after the redirect
        }
        ?>
        <?php include '../../Controller/doctorController.php';?>
        <?php include '../../Controller/secretaryController.php';?>
        <?php include '../../Controller/appointmentController.php';?>
        <?php include '../../Controller/weekScheduleController.php';?>
        <?php if($_GET['section'] === "doctor"): ?>
            <?php include '../components/secretary/docSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "bookedApp"): ?>
            <?php include '../components/secretary/BookedAppSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "acceptedApp"): ?>
            <?php include '../components/secretary/acceptedAppSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "print"): ?>
            <?php include '../components/secretary/printSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "pass"): ?>
            <?php include '../components/changePassword.php'; ?>
        <?php endif; ?>
    <?php endif; ?>


    <?php 
    if(isset($_SESSION['user']) && $_SESSION['user'] == "doctor") : 
    ?>
    <br>
    <br>
    <br>
    <div class="container">
        <br> <br> <br>
        <h1 class="alert alert-info">Hello Dr. <?=$_SESSION['name']?></h1>
        <div class="row mb-5">
            <div class="col">
            <a href="home.php?section=fess" class="btn btn-primary">Fees</a>
            <a href="home.php?section=consultation  " class="btn btn-primary">Consultation</a>
            <a href="home.php?section=pending  " class="btn btn-primary">Pending Appointments</a>
            <a href="home.php?section=pass  " class="btn btn-primary">Change Password</a>
            </div>
        </div>
    </div>
        <?php
        // Check if the "section" parameter is not set in the URL
        if (!isset($_GET['section'])) {
            // Redirect the user to the "doctor" section
            header('Location: home.php?section=fess');
            exit; // Ensure that no further code is executed after the redirect
        }
        ?>
        <?php include '../../Controller/appointmentController.php';?>
        <?php include '../../Controller/consultationController.php';?>
        <?php if($_GET['section'] === "fess"): ?>
            <?php include '../components/doctor/feesSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "consultation"): ?>
            <?php include '../components/doctor/consultationSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "pending"): ?>
            <?php include '../components/doctor/beforeAcceptingSection.php'; ?>
        <?php endif; ?>
        <?php if($_GET['section'] === "pass"): ?>
            <?php include '../components/changePassword.php'; ?>
        <?php endif; ?>
    <?php endif; ?>


    <?php include '../components/footer.php'; ?>
</body>

</html>