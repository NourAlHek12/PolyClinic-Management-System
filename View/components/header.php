<?php
session_start();
?>
<header>
    <nav class="navbar navbar-expand-lg" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php" id="logo"><img src="../images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span><i class="fa-solid fa-bars" style="color: white;"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="home.php">Home</a>
                    </li>
                    <?php
                    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user'] != "manager" && $_SESSION['user'] != "secretary"  && $_SESSION['user'] != "doctor")):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#services">Services</a>
                    </li>

                    <?php if(isset($_SESSION['user']) && $_SESSION['user'] === "patient") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="notification.php">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="app.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consultation.php">Consultation</a>
                    </li>
                    <?php endif; ?>
                     <li class="nav-item" id="loc">
                        <a href="./#location">
                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                        <a class="nav-link" href="../../post/logout.php">logout</a>
                    </li>
                    <?php endif; ?>

                    
                </ul>
                <?php
                    if(!isset($_SESSION['user'])):
                ?>
                <form class="d-flex">
                    <a class="btn-green" onclick="app()"><i class="fa-solid fa-calendar-days"></i> Make An
                        Appointment</a>
                </form>
                <?php endif; ?>
            </div>
            <br>
            <br> <br>
        </div>
    </nav>
</header>

<script>
    var header = document.getElementsByTagName("header");
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            header[0].setAttribute("class", "header-active");
        } else {
            header[0].removeAttribute("class");
        }
    }

    function app() {
    document.location.href = "./patientLogin.php";
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
</script>
<style>
    header {
        position: fixed;
        background: navy;
        z-index: 1;
        top: 0;
        animation-name: example;
        animation-duration: 0.8s;
    }
</style>