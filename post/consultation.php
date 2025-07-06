<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/consultationController.php';
if(isset($_POST['consultation'])){
    $appId = $_POST['appId'];
    $notes  = $_POST['notes'];
    $allergy = $_POST['allergy'];
    $prevTreat  = $_POST['prevTreat'];
    $currentTreat = $_POST['currentTreat'];
    $labResult = $_POST['labResult'];

    // Call the insertConsultation function
    $result = insertConsultation($appId, $notes, $allergy, $prevTreat, $currentTreat, $labResult);

    // Check if the insertion/update was successful
    if($result) {
        // Consultation details inserted/updated successfully
        $_SESSION['message'] = "Consultation details saved successfully.";
    } else {
        // Failed to insert/update consultation details
        $_SESSION['message'] = "Failed to save consultation details.";
    }
    header("Location:../View/pages/home.php?section=fess");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = deleteConsultation($id);
    if($result) {
        $_SESSION['message'] = "Consultation deleted successfully";
    } else {
        $_SESSION['message'] = "Consultation deleted error";
    }
    header("Location:../View/pages/home.php?section=consultation"); 
}



