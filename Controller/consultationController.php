<?php
function insertConsultation($appId, $notes, $allergy, $previousTreatment, $currentTreatment, $laboratoryResult) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement
    $query = "INSERT INTO consultation (appointmentId, notes, allergy, previousTreatment, currentTreatment, laboratoryResult)
              VALUES (?, ?, ?, ?, ?, ?) 
              ON DUPLICATE KEY UPDATE 
              notes = VALUES(notes), 
              allergy = VALUES(allergy), 
              previousTreatment = VALUES(previousTreatment), 
              currentTreatment = VALUES(currentTreatment), 
              laboratoryResult = VALUES(laboratoryResult)";
    $stmt = $mysqli->prepare($query);

    // Bind the parameters
    $stmt->bind_param("isssss", $appId, $notes, $allergy, $previousTreatment, $currentTreatment, $laboratoryResult);

    // Execute the statement
    $stmt->execute();

    // Check if the insertion/update was successful
    if ($stmt->affected_rows > 0) {
        // Insertion/update successful
        return true;
    } else {
        // Insertion/update failed
        return false;
    }
}

function getAllConsultations($doctorId){
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT 
                consultation.id AS consultationId, 
                consultation.notes AS notes, 
                consultation.allergy AS allergy, 
                consultation.previousTreatment AS previousTreatment, 
                consultation.laboratoryResult AS laboratoryResult, 
                consultation.currentTreatment AS currentTreatment, 
                appointment.id AS appointmentId, 
                appointment.start AS appointmentStart, 
                appointment.end AS appointmentEnd, 
                appointment.status AS appointmentStatus, 
                appointment.fees AS appointmentFees, 
                appointment.createdAt AS appointmentCreatedAt, 
                doctor.id AS doctorId, 
                doctor.firstName AS doctorFirstName, 
                doctor.lastName AS doctorLastName, 
                doctor.gmail AS doctorGmail, 
                doctor.password AS doctorPassword, 
                doctor.picture AS doctorPicture, 
                doctor.phone AS doctorPhone, 
                patient.id AS patientId, 
                patient.firstName AS patientFirstName, 
                patient.lastName AS patientLastName, 
                patient.gmail AS patientGmail, 
                patient.password AS patientPassword, 
                patient.phone AS patientPhone, 
                secretary.id AS secretaryId, 
                secretary.name AS secretaryName, 
                secretary.phone AS secretaryPhone, 
                secretary.password AS secretaryPassword
            FROM consultation 
            LEFT JOIN appointment ON consultation.appointmentId = appointment.id 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE doctor.id = ?
            AND appointment.fees IS NOT NULL";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $doctorId);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store consultations
    $consultations = [];
    
    // Fetch data and create consultation objects
    while ($row = $result->fetch_assoc()) {
        // Create patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null // You may need to retrieve doctor's specialty from the database
        );

        // Create secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword'] // Assuming the password is necessary for the Secretary object
        );

        // Create appointment object
        $appointment = new Appointment(
            $row['appointmentId'],
            $doctor,
            $patient,
            $row['appointmentStart'],
            $row['appointmentEnd'],
            $row['appointmentStatus'],
            $row['appointmentFees'],
            $secretary,
            $row['appointmentCreatedAt']
        );

        // Create consultation object
        $consultation = new Consultation(
            $row['consultationId'],
            $appointment,
            $row['notes'],
            $row['allergy'],
            $row['previousTreatment'],
            $row['laboratoryResult'],
            $row['currentTreatment']
        );

        // Add consultation to array
        $consultations[] = $consultation;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the consultations array
    return $consultations;
}

function deleteConsultation($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "DELETE FROM consultation WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameters
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        // Deletion successful
        return true;
    } else {
        // Deletion failed
        return false;
    }
}

function getPatientConsultation($patientId){
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT 
                consultation.id AS consultationId, 
                consultation.notes AS notes, 
                consultation.allergy AS allergy, 
                consultation.previousTreatment AS previousTreatment, 
                consultation.laboratoryResult AS laboratoryResult, 
                consultation.currentTreatment AS currentTreatment, 
                appointment.id AS appointmentId, 
                appointment.start AS appointmentStart, 
                appointment.end AS appointmentEnd, 
                appointment.status AS appointmentStatus, 
                appointment.fees AS appointmentFees, 
                appointment.createdAt AS appointmentCreatedAt, 
                doctor.id AS doctorId, 
                doctor.firstName AS doctorFirstName, 
                doctor.lastName AS doctorLastName, 
                doctor.gmail AS doctorGmail, 
                doctor.password AS doctorPassword, 
                doctor.picture AS doctorPicture, 
                doctor.phone AS doctorPhone, 
                patient.id AS patientId, 
                patient.firstName AS patientFirstName, 
                patient.lastName AS patientLastName, 
                patient.gmail AS patientGmail, 
                patient.password AS patientPassword, 
                patient.phone AS patientPhone, 
                secretary.id AS secretaryId, 
                secretary.name AS secretaryName, 
                secretary.phone AS secretaryPhone, 
                secretary.password AS secretaryPassword
            FROM consultation 
            LEFT JOIN appointment ON consultation.appointmentId = appointment.id 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE patient.id = ? AND appointment.status = 'accepted'";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $patientId);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store consultations
    $consultations = [];
    
    // Fetch data and create consultation objects
    while ($row = $result->fetch_assoc()) {
        // Create patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null // You may need to retrieve doctor's specialty from the database
        );

        // Create secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword'] // Assuming the password is necessary for the Secretary object
        );

        // Create appointment object
        $appointment = new Appointment(
            $row['appointmentId'],
            $doctor,
            $patient,
            $row['appointmentStart'],
            $row['appointmentEnd'],
            $row['appointmentStatus'],
            $row['appointmentFees'],
            $secretary,
            $row['appointmentCreatedAt']
        );

        // Create consultation object
        $consultation = new Consultation(
            $row['consultationId'],
            $appointment,
            $row['notes'],
            $row['allergy'],
            $row['previousTreatment'],
            $row['laboratoryResult'],
            $row['currentTreatment']
        );

        // Add consultation to array
        $consultations[] = $consultation;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the consultations array
    return $consultations;
}

function getSingleConsultationRecords($phone,$doctorId){
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT 
                consultation.id AS consultationId, 
                consultation.notes AS notes, 
                consultation.allergy AS allergy, 
                consultation.previousTreatment AS previousTreatment, 
                consultation.laboratoryResult AS laboratoryResult, 
                consultation.currentTreatment AS currentTreatment, 
                appointment.id AS appointmentId, 
                appointment.start AS appointmentStart, 
                appointment.end AS appointmentEnd, 
                appointment.status AS appointmentStatus, 
                appointment.fees AS appointmentFees, 
                appointment.createdAt AS appointmentCreatedAt, 
                doctor.id AS doctorId, 
                doctor.firstName AS doctorFirstName, 
                doctor.lastName AS doctorLastName, 
                doctor.gmail AS doctorGmail, 
                doctor.password AS doctorPassword, 
                doctor.picture AS doctorPicture, 
                doctor.phone AS doctorPhone, 
                patient.id AS patientId, 
                patient.firstName AS patientFirstName, 
                patient.lastName AS patientLastName, 
                patient.gmail AS patientGmail, 
                patient.password AS patientPassword, 
                patient.phone AS patientPhone, 
                secretary.id AS secretaryId, 
                secretary.name AS secretaryName, 
                secretary.phone AS secretaryPhone, 
                secretary.password AS secretaryPassword
            FROM consultation 
            LEFT JOIN appointment ON consultation.appointmentId = appointment.id 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE patient.phone = ? AND doctorId = $doctorId";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $phone);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store consultations
    $consultations = [];
    
    // Fetch data and create consultation objects
    while ($row = $result->fetch_assoc()) {
        // Create patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null // You may need to retrieve doctor's specialty from the database
        );

        // Create secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']// Assuming the password is necessary for the Secretary object
        );

        // Create appointment object
        $appointment = new Appointment(
            $row['appointmentId'],
            $doctor,
            $patient,
            $row['appointmentStart'],
            $row['appointmentEnd'],
            $row['appointmentStatus'],
            $row['appointmentFees'],
            $secretary,
            $row['appointmentCreatedAt']
        );

        // Create consultation object
        $consultation = new Consultation(
            $row['consultationId'],
            $appointment,
            $row['notes'],
            $row['allergy'],
            $row['previousTreatment'],
            $row['laboratoryResult'],
            $row['currentTreatment']
        );

        // Add consultation to array
        $consultations[] = $consultation;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the consultations array
    return $consultations;
}
function getSingleConsultationRecordsByDate($date,$doctorId){
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT 
                consultation.id AS consultationId, 
                consultation.notes AS notes, 
                consultation.allergy AS allergy, 
                consultation.previousTreatment AS previousTreatment, 
                consultation.laboratoryResult AS laboratoryResult, 
                consultation.currentTreatment AS currentTreatment, 
                appointment.id AS appointmentId, 
                appointment.start AS appointmentStart, 
                appointment.end AS appointmentEnd, 
                appointment.status AS appointmentStatus, 
                appointment.fees AS appointmentFees, 
                appointment.createdAt AS appointmentCreatedAt, 
                doctor.id AS doctorId, 
                doctor.firstName AS doctorFirstName, 
                doctor.lastName AS doctorLastName, 
                doctor.gmail AS doctorGmail, 
                doctor.password AS doctorPassword, 
                doctor.picture AS doctorPicture, 
                doctor.phone AS doctorPhone, 
                patient.id AS patientId, 
                patient.firstName AS patientFirstName, 
                patient.lastName AS patientLastName, 
                patient.gmail AS patientGmail, 
                patient.password AS patientPassword, 
                patient.phone AS patientPhone, 
                secretary.id AS secretaryId, 
                secretary.name AS secretaryName, 
                secretary.phone AS secretaryPhone, 
                secretary.password AS secretaryPassword
            FROM consultation 
            LEFT JOIN appointment ON consultation.appointmentId = appointment.id 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE DATE(appointment.start) = ? AND doctorId = $doctorId";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }

    // Bind the parameter
    $stmt->bind_param("s", $date);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store consultations
    $consultations = [];
    
    // Fetch data and create consultation objects
    while ($row = $result->fetch_assoc()) {
        // Create patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null // You may need to retrieve doctor's specialty from the database
        );

        // Create secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']// Assuming the password is necessary for the Secretary object
        );

        // Create appointment object
        $appointment = new Appointment(
            $row['appointmentId'],
            $doctor,
            $patient,
            $row['appointmentStart'],
            $row['appointmentEnd'],
            $row['appointmentStatus'],
            $row['appointmentFees'],
            $secretary,
            $row['appointmentCreatedAt']
        );

        // Create consultation object
        $consultation = new Consultation(
            $row['consultationId'],
            $appointment,
            $row['notes'],
            $row['allergy'],
            $row['previousTreatment'],
            $row['laboratoryResult'],
            $row['currentTreatment']
        );

        // Add consultation to array
        $consultations[] = $consultation;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the consultations array
    return $consultations;
}
