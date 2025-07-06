<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/weekScheduleController.php';
include '../Controller/appointmentController.php';
if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $day = $_POST['day'];
    $shift = $_POST['shift'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $roomId = $_POST['roomId'];

    $startTimestamp = strtotime($start);
    $endTimestamp = strtotime($end);

    if ($startTimestamp >= $endTimestamp) {
        // Start time is greater than or equal to end time
        $_SESSION['message'] = 'Start time should be before the end time';
        header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
        exit; // Exit to stop further execution
    }
    if ($shift === 'before') {  // 7 -> 15
        // If the shift is "before"
        if (strtotime($end) >= strtotime('15:00:00')) {
            // If the end time is after or equal to 3 PM
            $_SESSION['message'] = 'End time should be before 3 PM for "morning" shift';
            header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
            exit;
        }
        // Additional validation: At least should be 7:00 am
        if (strtotime($start) < strtotime('07:00:00')) {
            // If the start time is before 7:00 am
            $_SESSION['message'] = 'Start time should be at least 7:00 am for "morning" shift';
            header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
            exit;
        }
    } elseif ($shift === 'after') {//15->24
        // If the shift is "after"
        if (strtotime($start) <= strtotime('15:00:00')) {
            // If the start time is before or equal to 3 PM
            $_SESSION['message'] = 'Start time should be after 3 PM for "night" shift';
            header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
            exit;
        }
        // Additional validation: At most should be 12:00 pm
        if (strtotime($end) > strtotime('24:00:00')) {
            // If the end time is after 12:00 pm
            $_SESSION['message'] = 'End time should be at most 12:00 pm for "night" shift';
            header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
            exit;
        }
    }
    

    // Check if any of the fields are empty
    if (!empty($id) && !empty($day) && !empty($start) && !empty($end) && !empty($shift)) {
        // Call the function to insert or update the schedule
        // Assuming insertSchedule function is defined and returns true on success
        $result = insertSchedule($id,$day, $shift, $start, $end, $roomId);
        
        if ($result) {
            $_SESSION['message'] = 'Schedule added successfully';
        } else {
            $_SESSION['message'] = 'Error adding schedule because schedule already exists or a doctor is already have a schedule in this room number';
        }
    } else {
        $_SESSION['message'] = 'All fields are required';
    }

    header("Location:../View/pages/home.php?section=doctor&&id=" . $id);
    exit; // Exit to stop further execution
}

// id = 0
// appointments 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $idDoc = $_GET['idDoc'];
    $day = getDayOfSchedule($id); // monday tuesday 
    deleteAllAppointmentsByDayAndDoctorId($day,$idDoc);  // monday 
    
    if(!deleteSchedule($id)){
        $_SESSION['message'] = "error";
    }
    else{
        $_SESSION['message'] = "success";
    }
    header("Location:../View/pages/home.php?section=doctor&&id=" . $idDoc);
}
