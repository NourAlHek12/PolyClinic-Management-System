<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/authController.php';

if(isset($_POST['auth'])){
    if($_POST['auth'] === "man"){
        $id = $_POST['id'];
        $password = $_POST['password'];
        if(!managerLogin($id, $password)){
            $_SESSION['message'] = "Login failed  with wrong credentials ";
            header("Location:../View/pages/otherLogin.php?manager=auth");
            return;
        }
        $_SESSION['user'] = "manager";
        header("Location:../View/pages/home.php");
    }
    else if($_POST['auth'] === "sec"){
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        if(!secLogin($phone, $password)){
            $_SESSION['message'] = "Login failed  with wrong credentials ";
            header("Location:../View/pages/otherLogin.php?manager=auth");
            return;
        }
        $_SESSION['user'] = "secretary";
        header("Location:../View/pages/home.php");
    }
    else if($_POST['auth'] === "doctor"){
        $gmail = $_POST['gmail'];
        $password = $_POST['password'];
        $id = docLogin($gmail, $password);
        if($id != null) {
            // Doctor authenticated successfully
            // Start the session and store the doctor's ID
            $_SESSION['user'] = "doctor";
            $_SESSION['id'] = $id;
            // Redirect to the home page
            header("Location:../View/pages/home.php");
            exit(); // Make sure to exit after redirection
        }
        $_SESSION['message'] = " wrong credentials";
        header("Location:../View/pages/doctorLogin.php");
    }
    else if($_POST['auth'] === "patient"){
        $gmail = $_POST['gmail'];
        $password = $_POST['password'];
        $id = patientLogin($gmail, $password);
        if($id != null) {
            // Doctor authenticated successfully
            // Start the session and store the doctor's ID
            $_SESSION['user'] = "patient";
            $_SESSION['id'] = $id;
            // Redirect to the home page
            header("Location:../View/pages/home.php");
            exit(); // Make sure to exit after redirection
        }
        $_SESSION['message'] = " unseccefully ";
        header("Location:../View/pages/patientLogin.php");
        
    }
    else if($_POST['auth'] === "up"){
        echo 'up';
        $fn = $_POST['fn'];
        $ln = $_POST['ln'];
        $phone = $_POST['phone'];
        $gmail = $_POST['gmail'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $res = patientSignUp($fn, $ln, $phone, $gmail, $hashedPassword);
        
        // Check the result of patientSignUp
        if ($res) {
            // Sign-up successful
            $_SESSION['message']  = "Patient sign-up successful!";
        } else {
            // Sign-up failed
            $_SESSION['message']  =  "Failed to sign up. Email may already be registered.";
        }
        header("Location:../View/pages/patientLogin.php");
    }
}
else{
    echo 'disabled';
}