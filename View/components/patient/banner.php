<?php 
$specialities = getAllSpecialities();
?>
<!-- Banner -->
<section class="banner" id="banner">
        <div class="cona">
            <!-- <div class="banner-content">
                <img src="./images/bannerlogo.png" alt="banner-logo">
                <h3 style="color:darkblue">POLYCLINIC</h3>
                <h2 style="color:darkblue"><br>Weclome, to our polyclnic  <b style="color:blue, border-bottom: 5px"><?=$_SESSION['name'];?></b> </h2>
            </div> -->
            
            <div class="row" style=" padding-top: 0px ;">
                <div class="col-md-8 offset-md-2 text-center"
                style=" margin-top: 0px ;" >
                    <h2 class="welcome-heading mb-4">Welcome to our polyclinic</h2>
                    <!-- <?php session_start(); ?> -->
                    <h2 class="welcome-heading mb-4">
                    <span class="user-name"><?=$_SESSION['name'];?></span>
                    </h2>
                    <p class="lead">Thank you for choosing our services.</p>
                    <!-- Optional: Add some icons for a more professional look -->
                    <div class="mt-4">
                    <i class="fas fa-stethoscope fa-3x mr-3"></i> <!-- Icon for stethoscope -->
                    <i class="fas fa-user-md fa-3x mr-3"></i> <!-- Icon for doctor -->
                    <i class="fas fa-notes-medical fa-3x"></i> <!-- Icon for medical notes -->
                    </div>
                </div>
                </div>
            <div class="service" style="background:blue; margin-top: 30px ;">
                <?php foreach($specialities as $specialty): ?>
                    <a href="doctors.php?specialty=<?=$specialty->id?>">
                        <div class="service-content">
                            <?=$specialty->name;?> Section
                        </div>
                        <div class="service-btn">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="service-icon">
                            <i class="fa-solid fa-hospital-user"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            /* Custom styles */
            .welcome-heading {
            color: darkblue;
            }
            .user-name {
            color: blue;
            border-bottom: 5px solid blue;
            }
            body {
            margin: 0;
            padding: 0;
            }
            /* .cona{
           
            padding-bottom:50px;
            } */
        </style>
    </section>