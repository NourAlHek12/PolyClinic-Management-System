<?php
session_start();
if(isset($_SESSION['user'])){
    //logout
    session_destroy();
    header('Location:../View/pages/home.php');
}