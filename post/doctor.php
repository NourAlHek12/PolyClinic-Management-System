<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/doctorController.php';

if(isset($_POST['add'])){
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gmail = $_POST['gmail'];
    $password = $_POST['password']; // Remember to hash the password for security
    $phone = $_POST['phone'];
    $specialityId = $_POST['specialityId']; // Assuming you have a select field for selecting speciality
    
    $file = $_FILES['image'];
    // File properties
    $fileName = $file['name'];//abc
    $fileTmpName = $file['tmp_name'];//324324

    $fileError = $file['error'];
    // Check if there is no error
    if($fileError === 0) {
        // Specify the directory where you want to store the image
        $uploadDir = '../View/images/';
        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }

    // Generate a unique name for the image to prevent overwriting
    $uniqueFileName = uniqid('image_') . '_' . $fileName;
    $uploadPath = $uploadDir . $uniqueFileName;
    
    // Check if file was uploaded successfully
    if(move_uploaded_file($fileTmpName, $uploadPath)) {
        // Insert doctor into database
        if(insertDoctor($firstName, $lastName, $gmail, $password, $uniqueFileName, $phone, $specialityId)) {
            $_SESSION['message'] = "Successfully inserted";
            // Doctor inserted successfully
            echo "Doctor added successfully!";
            // Redirect to a success page or perform any other actions
        } else {
            // Error occurred while inserting doctor
            $_SESSION['message'] = "An error occurred while inserting doctor *+*";
            echo "Error: Unable to add doctor.";
        }
    } else {
        $_SESSION['message'] = "An error occurred while inserting doctor";
        // File upload failed
        echo "Error: File upload failed.";
    }
    header("Location:../View/pages/home.php");

}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(!deleteDoctor($id)){
        $_SESSION['messagee'] = "error in delete doctor";
    }
    else{
        $_SESSION['messagee'] = "success";
    }
    header("Location:../View/pages/home.php?section=doctor");
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gmail = $_POST['gmail'];
    $phone = $_POST['phone'];
    $specialityId = $_POST['specialityId'];

    if(!updateDoctor($id,$firstName,$lastName,$gmail,$phone,$specialityId)){
        $_SESSION['messagee'] = "error updating";
    }
    else{
        $_SESSION['messagee'] = "ok success";
    }
    header("Location:../View/pages/home.php?section=doctor");
}
