<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/specialityController.php';
if(isset($_POST['add'])){
    $name = $_POST['name'];
    // Check if the name is not empty
    if(!empty($name)) {
        // Attempt to insert the specialty
        if(insertSpeciality($name)) {
            $_SESSION['message'] = "inserted  successfully";
        } else {
            $_SESSION['message'] = "error";
        }
    } else {
        $_SESSION['message'] = "error";
    }
    header("Location:../View/pages/home.php?section=speciality");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(!deleteSpecialty($id)){
        $_SESSION['messagee'] = "error in deleteSpecialty";
    }
    else{
        $_SESSION['messagee'] = "success";
    }
    header("Location:../View/pages/home.php?section=speciality");
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    if(updateSpeciality($id,$name)){
        $_SESSION['messagee'] = "success";
    }
    header("Location:../View/pages/home.php?section=speciality");
}
