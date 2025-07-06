<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/roomController.php';

if(isset($_POST['add'])){
    $number = $_POST['number'];
    $desc = $_POST['desc'];
    if(addRoom($number,$desc)){
        $_SESSION['message'] = 'Room added successfully';
    }
    else{
        $_SESSION['message'] = 'Room not added successfully';
    }
    header("Location:../View/pages/home.php?section=room");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(deleteRoom($id)){
        $_SESSION['message'] = 'Room deleted successfully';
    }
    else{
        $_SESSION['message'] = 'Room not deleted successfully';
    }
    header("Location:../View/pages/home.php?section=room");
}

if(isset($_POST['update'])){
    $id = $_POST['idToUpdate'];
    $number = $_POST['number'];
    $desc = $_POST['desc'];
    if(updateRoom($number,$desc,$id)){
        $_SESSION['message'] = 'Room updated successfully';
    }
    else{
        $_SESSION['message'] = 'Room not updated successfully';
    }
    header("Location:../View/pages/home.php?section=room");
}