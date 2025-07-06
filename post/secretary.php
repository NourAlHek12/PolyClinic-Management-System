<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/secretaryController.php';
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    // Check if the name is not empty
    if( !empty($phone) && !empty($password) && !empty($name)) {
        // Attempt to insert the specialty
        if(insertSecretary($name, $phone, $password)) {
            $_SESSION['message'] = "inserted  successfully";
        } else {
            $_SESSION['message'] = "error in insertion secretary";
        }
    } else {
        $_SESSION['message'] = "error emptying...";
    }
    header("Location:../View/pages/home.php?section=secretary");
}


if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(!deleteSecretary($id)){
        $_SESSION['messagee'] = "error in delete secretary";
    }
    else{
        $_SESSION['messagee'] = "success";
    }
    header("Location:../View/pages/home.php?section=secretary");
}

if(isset($_POST['id'])){
    // update
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    if(updateSecretary($id,$name,$phone)){
        $_SESSION['messagee'] = "updated successfully";
    }
    else{
        $_SESSION['messagee'] = "error";
    }
    header("Location:../View/pages/home.php?section=secretary");
}
// Redirect back to appointments page
