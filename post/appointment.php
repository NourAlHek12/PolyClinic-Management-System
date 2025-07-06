<?php
session_start();
include '../utils/autoLoad.php';
include '../utils/connectToDb.php';
include '../Controller/appointmentController.php';
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $status = $_GET['action'];//accpeted / rejected / block
    if($status == 'block'){
        $patientId = getAppointmentOwner($id);
        blockPatient($patientId);
        deleteAllAppointmentsOfOwnerId($patientId);
        header("Location:../View/pages/home.php?section=bookedApp");
        return;
    }
    // Call the updateAppointmentStatus function
    if (updateAppointmentStatus($id, $status)) {
        // Appointment status updated successfully
        $_SESSION['message'] = "Appointment status updated successfully.";
    } else {
        // Appointment status update failed
        $_SESSION['message'] = "Failed to update appointment status.";
    }
    if($_SESSION['user'] == "doctor"){
        header("Location:../View/pages/home.php?section=pending");
        exit;
    }
    header("Location:../View/pages/home.php?section=bookedApp");
} 

if(isset($_POST['feesAdd'])){
    $appId = $_POST['appId'];
    $fees = $_POST['fees'];
    $secretaryId = $_SESSION['id'];
    
    // Call the function to update appointment fees
    $res = updateAppointmentFees($appId, $fees, $secretaryId);
    
    if($res) {
        $_SESSION['message'] = "Appointment fees updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update appointment fees.";
    }
    
    // Redirect back to the page where the form was submitted
    header("Location:../View/pages/home.php?section=acceptedApp");
}

if(isset($_POST['app'])){
    $day = $_POST['day'];
    $start = $_POST['start'];
    $end = date('H:i:s', strtotime($start . ' +30 minutes'));
    
    $doctorId = $_POST['doctorId'];

    // Combine date and time for start and end
    $startDatetime = new DateTime("$day $start");
    $endDatetime = new DateTime("$day $end");
    
    // Format the DateTime objects as strings
    $startString = $startDatetime->format('Y-m-d H:i:s');
    $endString = $endDatetime->format('Y-m-d H:i:s');
    
    // Call the insertAppointment function with formatted date strings
    $res = insertAppointment($doctorId, $_SESSION['id'], $startString, $endString);
    /*
    true 
    conflict  
    */
    if($res !== true){
        $_SESSION['message'] = $res;
    }
    else{
        $_SESSION['message'] = 'success';
    }
    header('Location:../View/pages/schedule.php?doctorId='.$doctorId);
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];  
    $res = delAppointment($id);
    if($res){
        $_SESSION['message'] = "Deleted successfully";
    }
    else{
        $_SESSION['message'] = "unDeleted";
    }
    header('Location:../View/pages/app.php');
}

/** pdf */
if(isset($_GET['idToPrint'])){
    require_once('../tcpdf/TCPDF-main/tcpdf.php');
    function generateAppointmentPDF($appointmentId) {
        // Fetch appointment data
        $appointmentData = fetchAppointmentData($appointmentId);
        
        // Create a new TCPDF object
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', '', 12);
        
        // Add appointment data to PDF
        $pdf->Write(0, 'Appointment Details', '', 0, 'C');
        $pdf->Ln(10);
        
        $pdf->Cell(0, 10, 'Appointment ID: ' . $appointmentData['appointmentId'], 0, 1);
        $pdf->Cell(0, 10, 'Appointment Start: ' . $appointmentData['appointmentStart'], 0, 1);
        $pdf->Cell(0, 10, 'Appointment End: ' . $appointmentData['appointmentEnd'], 0, 1);
        $pdf->Cell(0, 10, 'Appointment Patient: ' . $appointmentData['patientFirstName']." ".$appointmentData['patientLastName'] , 0, 1);
        $pdf->Cell(0, 10, 'Appointment Doctor: ' . $appointmentData['doctorFirstName']." ".$appointmentData['doctorLastName'], 0, 1);
        $pdf->Cell(0, 10, 'Appointment fees: ' . $appointmentData['appointmentFees']."$", 0, 1);
        $pdf->SetTextColor(0, 0, 255); // Set link color to blue
        $pdf->SetFont('', 'U'); // Underline the text
        $pdf->Cell(0, 10, 'Back', 0, 1, '', false, '../View/pages/home.php?section=print');
        $pdf->SetTextColor(0); // Reset text color
        $pdf->SetFont('');

        // Add more appointment data fields as needed...
        
        // Output PDF
        $pdf->Output('appointment_details.pdf', 'I');
    }
    // Call the function to generate PDF for a specific appointment ID
    generateAppointmentPDF($_GET['idToPrint']);
}