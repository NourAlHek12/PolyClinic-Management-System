<?php
/*  7  days after ending  */
function getAllAccptedAppointments() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    $query = "SELECT 
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
    FROM appointment 
    LEFT JOIN doctor ON appointment.doctorId = doctor.id 
    LEFT JOIN patient ON appointment.patientId = patient.id 
    LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
    WHERE appointment.status = 'accepted'

    AND appointment.fees IS NULL;";


    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}
/*-----------------------------------------------------------------*/
/** */
function getAllCompletedAppointments($doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
        FROM appointment 
        LEFT JOIN doctor ON appointment.doctorId = doctor.id 
        LEFT JOIN patient ON appointment.patientId = patient.id 
        LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
        WHERE appointment.status = 'accepted'
        AND doctorId = $doctorId
        AND appointment.fees IS NOT NULL
        ";
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}
function getAllCompletedAppointment() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
        FROM appointment 
        LEFT JOIN doctor ON appointment.doctorId = doctor.id 
        LEFT JOIN patient ON appointment.patientId = patient.id 
        LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
        WHERE appointment.status = 'accepted'
        AND appointment.fees IS NOT NULL
        ";
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}
function getAllCompletedAppointmentsByPatientPhone($phone,$doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all completed appointments with related data
    $query = "SELECT 
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
            FROM appointment 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE appointment.status = 'accepted'
            AND appointment.fees IS NOT NULL
            AND doctorId = $doctorId
            AND patient.phone = ?";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }

    // Bind the parameter
    $stmt->bind_param("s", $phone);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store appointments
    $appointments = [];
    
    // Fetch data and create appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the array of appointments
    return $appointments;
}
function getAllCompletedAppointmentsByDate($date,$doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all completed appointments with related data
    $query = "SELECT 
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
            FROM appointment 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE appointment.status = 'accepted'
            AND appointment.fees IS NOT NULL
            AND doctorId  = $doctorId
            AND DATE(appointment.start) = ?";
    
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
    
    // Initialize an array to store appointments
    $appointments = [];
    
    // Fetch data and create appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the array of appointments
    return $appointments;
}

/** */
function getAllPendingAppointments($doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
        FROM appointment 
        LEFT JOIN doctor ON appointment.doctorId = doctor.id 
        LEFT JOIN patient ON appointment.patientId = patient.id 
        LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
        WHERE appointment.fees IS NULL
        AND appointment.status != 'rejected'
        AND doctor.id = 
        ".$doctorId;
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}

function getAllBookedAppointments() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
              FROM appointment 
              LEFT JOIN doctor ON appointment.doctorId = doctor.id 
              LEFT JOIN patient ON appointment.patientId = patient.id 
              LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
              WHERE appointment.status = 'booked'
              AND appointment.start >= NOW();    
              ";
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryPhone'],
            $row['secretaryName'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}

function updateAppointmentStatus($id, $status) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement to update appointment status
    $queryUpdate = "UPDATE appointment SET status = ? WHERE id = ?";
    $stmtUpdate = $mysqli->prepare($queryUpdate);

    // Check for SQL statement preparation errors
    if (!$stmtUpdate) {
        // Handle the error
        echo "Error preparing update statement: " . $mysqli->error;
        return false;
    }
    
    // Bind parameters for the update statement
    $stmtUpdate->bind_param("si", $status, $id);
    
    // Execute the update statement
    $stmtUpdate->execute();

    // Check for SQL statement execution errors
    if ($stmtUpdate->errno) {
        // Handle the error
        echo "Error executing update statement: " . $stmtUpdate->error;
        return false;
    }
    
    // Check if the update was successful
    if ($stmtUpdate->affected_rows > 0) {
        // Update successful
        
        // Insert or update a notification
        $content = "Appointment status changed to: " . $status;
        $queryNotification = "INSERT INTO notification (appointmentId, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?";
        $stmtNotification = $mysqli->prepare($queryNotification);

        // Check for SQL statement preparation errors
        if (!$stmtNotification) {
            // Handle the error
            echo "Error preparing notification statement: " . $mysqli->error;
            return false;
        }
        
        // Bind parameters for the notification statement
        $stmtNotification->bind_param("iss", $id, $content, $content);
        
        // Execute the notification statement
        $stmtNotification->execute();

        // Check for SQL statement execution errors
        if ($stmtNotification->errno) {
            // Handle the error
            echo "Error executing notification statement: " . $stmtNotification->error;
            return false;
        }

        // Notification successfully inserted or updated
        return true;
    } else {
        // Update failed
        return false;
    }
}

function updateAppointmentFees($id, $fees, $secretaryId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement to update appointment fees
    $queryUpdate = "UPDATE appointment SET fees = ?, secretaryId = ? WHERE id = ?";
    $stmtUpdate = $mysqli->prepare($queryUpdate);

    // Check for SQL statement preparation errors
    if (!$stmtUpdate) {
        // Handle the error
        echo "Error preparing update statement: " . $mysqli->error;
        return false;
    }
    
    // Bind parameters for the update statement
    $stmtUpdate->bind_param("dii", $fees, $secretaryId, $id);
    
    // Execute the update statement
    $stmtUpdate->execute();

    // Check for SQL statement execution errors
    if ($stmtUpdate->errno) {
        // Handle the error
        echo "Error executing update statement: " . $stmtUpdate->error;
        return false;
    }
    
    // Check if the update was successful
    if ($stmtUpdate->affected_rows > 0) {
        // Update successful
        
        // Insert a notification
        $content = "Appointment fees updated to: $" . $fees;
        $queryNotification = "INSERT INTO notification (appointmentId, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?";
        $stmtNotification = $mysqli->prepare($queryNotification);

        // Check for SQL statement preparation errors
        if (!$stmtNotification) {
            // Handle the error
            echo "Error preparing notification statement: " . $mysqli->error;
            return false;
        }
        
        // Bind parameters for the notification statement
        $stmtNotification->bind_param("iss", $id, $content, $content);
        
        // Execute the notification statement
        $stmtNotification->execute();

        // Check for SQL statement execution errors
        if ($stmtNotification->errno) {
            // Handle the error
            echo "Error executing notification statement: " . $stmtNotification->error;
            return false;
        }

        // Notification successfully inserted
        return true;
    } else {
        // Update failed
        return false;
    }
}
function getDoctorAppointmentByDate($date, $doctorId) {
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare SQL statement to retrieve appointments for the given date and doctor
    $query = "SELECT * FROM appointment WHERE (DATE(start) = ? OR DATE(end) = ?) AND doctorId = ? AND appointment.status != 'rejected'";
    $stmt = $mysqli->prepare($query);

    // Check for SQL statement preparation errors
    if (!$stmt) {
        // Handle the error
        echo "Error preparing statement: " . $mysqli->error;
        return null;
    }

    // Bind parameters
    $stmt->bind_param("ssi", $date, $date, $doctorId);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an array to store Appointment objects
    $appointments = array();

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Construct the Appointment object
        $appointment = new Appointment(
            $row['id'],
            null, // Replace null with the appropriate Doctor object
            null, // Replace null with the appropriate Patient object
            $row['start'],
            $row['end'],
            null, // Replace null with the appropriate status
            null, // Replace null with the appropriate fees
            null, // Replace null with the appropriate Secretary object
            null // Replace null with the appropriate createdAt value
        );
        
        // Add the Appointment object to the array
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();
    
    // Return the array of Appointment objects
    return $appointments;
}

function cancelAppointment($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Check if the appointment status is "accepted"
    $queryStatus = "SELECT status FROM appointment WHERE id = ?";
    $stmtStatus = $mysqli->prepare($queryStatus);
    $stmtStatus->bind_param("i", $id);
    $stmtStatus->execute();
    $stmtStatus->bind_result($status);
    $stmtStatus->fetch();
    $stmtStatus->close();

    if ($status != 'accepted') {
        $queryDelete = "DELETE FROM appointment WHERE id = ?";
        $stmtDelete = $mysqli->prepare($queryDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();
        $stmtDelete->close();
        return "Appointment deleted successfully.";
    }
}


function showAllAppointmentsByPatient($patientId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare SQL statement to retrieve appointments for the given patient
    $query = "SELECT appointment.*, doctor.firstName AS doctorFirstName, doctor.lastName AS doctorLastName, doctor.picture AS doctorPicture
              FROM appointment
              JOIN doctor ON appointment.doctorId = doctor.id
              WHERE appointment.patientId = ?
              ORDER BY appointment.createdAt DESC";
    $stmt = $mysqli->prepare($query);

    // Bind parameter
    $stmt->bind_param("i", $patientId);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an array to store appointment objects
    $appointments = array();

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create an Appointment object and add it to the array
        $appointment = new Appointment(
            $row['id'],
            new Doctor(
                $row['doctorId'],
                $row['doctorFirstName'],
                $row['doctorLastName'],
                null, // Gmail
                null, // Password
                $row['doctorPicture'],
                null, // Phone
                null  // Speciality
            ),
            $row['patientId'],
            $row['start'],
            $row['end'],
            $row['status'],
            $row['fees'],
            $row['secretaryId'],
            $row['createdAt']
        );
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();

    // Return the array of appointments
    return $appointments;
}

//?------------------------------------------------------------------
/**        filtering booked appointments         */
function showAllBookedAppointmentsByDoctorName($name) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
              FROM appointment 
              LEFT JOIN doctor ON appointment.doctorId = doctor.id 
              LEFT JOIN patient ON appointment.patientId = patient.id 
              LEFT JOIN secretary ON appointment.secretaryId = secretary.id
              WHERE appointment.status = 'booked'
              AND (doctor.firstName LIKE CONCAT('%', ?, '%') OR doctor.lastName LIKE CONCAT('%', ?, '%'))
              AND appointment.start >= NOW() ;";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }

    // Bind the parameter
    $stmt->bind_param("ss", $name, $name);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if (!$result) {
        // Handle the error if getting the result set fails
        $stmt->close();
        return false;
    }

    // Initialize an array to store appointment objects
    $appointments = [];

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );

        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryPhone'],
            $row['secretaryName'],
            $row['secretaryPassword']
        );

        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();

    // Return the array of appointments
    return $appointments;
}

function showAllBookedAppointmentsByStartDate($date) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
              FROM appointment 
              LEFT JOIN doctor ON appointment.doctorId = doctor.id 
              LEFT JOIN patient ON appointment.patientId = patient.id 
              LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
              WHERE appointment.status = 'booked' AND DATE(appointment.start) = ?
              AND appointment.start >= NOW();";

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

    // Get the result set
    $result = $stmt->get_result();

    if (!$result) {
        // Handle the error if getting the result set fails
        $stmt->close();
        return false;
    }

    // Initialize an array to store appointment objects
    $appointments = [];

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );

        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryPhone'],
            $row['secretaryName'],
            $row['secretaryPassword']
        );

        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();

    // Return the array of appointments
    return $appointments;
}

function showAllBookedAppointmentsByStartDateAndDoctorName($date, $doctorName) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    $query = "SELECT 
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
              FROM appointment 
              LEFT JOIN doctor ON appointment.doctorId = doctor.id 
              LEFT JOIN patient ON appointment.patientId = patient.id 
              LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
              WHERE appointment.status = 'booked' AND DATE(appointment.start) = ?
              AND (doctor.firstName LIKE CONCAT('%', ?, '%') OR doctor.lastName LIKE CONCAT('%', ?, '%'))
              AND appointment.start >= NOW();    ";

    $stmt = $mysqli->prepare($query);

    // Bind parameters
    $stmt->bind_param("sss", $date, $doctorName, $doctorName);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an array to store appointment objects
    $appointments = array();

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );

        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryPhone'],
            $row['secretaryName'],
            $row['secretaryPassword']
        );

        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();

    // Return the array of appointments
    return $appointments;
}
/**         filtering accepted appoitments  */
function getAllAccptedAppointmentsByPatientPhone($phone) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
            FROM appointment 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE appointment.status = 'accepted'
            AND appointment.fees IS NULL AND patient.phone = $phone;";
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        // Handle the error if the query fails
        return false;
    }
    
    // Fetch all rows from the result set
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Free the result set
    $result->free();
    
    // Return the array of appointments
    return $appointments;
}
function getAllAccptedAppointmentsByStartDate($date) {  
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement with JOINs to retrieve all booked appointments with related data
    $query = "SELECT 
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
              FROM appointment 
              LEFT JOIN doctor ON appointment.doctorId = doctor.id 
              LEFT JOIN patient ON appointment.patientId = patient.id 
              LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
              WHERE appointment.status = 'accepted' AND DATE(appointment.start) = ?
              AND appointment.fees is not null;";

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

    // Get the result set
    $result = $stmt->get_result();

    if (!$result) {
        // Handle the error if getting the result set fails
        $stmt->close();
        return false;
    }

    // Initialize an array to store appointment objects
    $appointments = [];

    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );

        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );

        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryPhone'],
            $row['secretaryName'],
            $row['secretaryPassword']
        );

        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }

    // Close the statement
    $stmt->close();

    // Return the array of appointments
    return $appointments;
}

/*        filtering completed appointments */
function getAllCompletedAppointmentsByPhone($phone) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement with parameterized query
    $query = "SELECT 
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
            FROM appointment 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE appointment.status = 'accepted'
            AND patient.phone = ?
            AND appointment.fees IS NOT NULL";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("s", $phone);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    
    // Initialize an array to store appointments
    $appointments = [];
    
    // Fetch appointments and create Appointment objects
    while ($row = $result->fetch_assoc()) {
        // Create Doctor object
        $doctor = new Doctor(
            $row['doctorId'],
            $row['doctorFirstName'],
            $row['doctorLastName'],
            $row['doctorGmail'],
            $row['doctorPassword'],
            $row['doctorPicture'],
            $row['doctorPhone'],
            null
        );
        
        // Create Patient object
        $patient = new Patient(
            $row['patientId'],
            $row['patientFirstName'],
            $row['patientLastName'],
            $row['patientGmail'],
            $row['patientPassword'],
            $row['patientPhone']
        );
        
        // Create Secretary object
        $secretary = new Secretary(
            $row['secretaryId'],
            $row['secretaryName'],
            $row['secretaryPhone'],
            $row['secretaryPassword']
        );
        
        // Create an Appointment object and add it to the array
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
        $appointments[] = $appointment;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the array of appointments
    return $appointments;
}

//?----------------------------------------------------------------

function insertAppointment($doctorId, $patientId, $start, $end)
{
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();


    // No conflict, insert the appointment
    $queryInsert = "INSERT INTO appointment (doctorId, patientId, start, end) VALUES (?, ?, ?, ?)";
    $stmtInsert = $mysqli->prepare($queryInsert);

    $stmtInsert->bind_param("iiss", $doctorId, $patientId, $start, $end);

    if (!$stmtInsert->execute()) {
        // Handle query execution error
        error_log("Appointment Insertion Query Execution Error: " . $stmtInsert->error);
        return "error in Appointment Insertion";
    }

    return true;
}

function delAppointment($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare SQL statement to delete the appointment
    $query = "DELETE FROM appointment WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle query preparation error
        error_log("Appointment Deletion Query Preparation Error: " . $mysqli->error);
        return false;
    }

    // Bind parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    if (!$stmt->execute()) {
        // Handle query execution error
        error_log("Appointment Deletion Query Execution Error: " . $stmt->error);
        return false;
    }

    // Close the statement
    $stmt->close();

    // Return true if deletion was successful
    return true;
}


//? printing
function fetchAppointmentData($appointmentId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement to fetch appointment data
    $query = "SELECT 
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
            FROM appointment 
            LEFT JOIN doctor ON appointment.doctorId = doctor.id 
            LEFT JOIN patient ON appointment.patientId = patient.id 
            LEFT JOIN secretary ON appointment.secretaryId = secretary.id 
            WHERE appointment.id = ?";
    
    // Prepare and bind the parameter
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $appointmentId);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    
    // Fetch appointment data
    $appointmentData = $result->fetch_assoc();
    
    // Close the statement
    $stmt->close();
    
    // Return the appointment data
    return $appointmentData;
}




//! block patient : 
function blockPatient($patientId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "UPDATE patient SET blocked = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $patientId);
    
    // Execute the statement
    if (!$stmt->execute()) {
        // Handle the error if the execution fails
        return false;
    }
    
    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Patient blocked successfully
        return true;
    } else {
        // No rows were affected, patient might not exist
        return false;
    }
}

function getAppointmentOwner($appId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT patientId FROM appointment WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return null;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $appId);
    
    // Execute the statement
    if (!$stmt->execute()) {
        // Handle the error if the execution fails
        return null;
    }
    
    // Store the result
    $stmt->bind_result($patientId);
    
    // Fetch the result
    if ($stmt->fetch()) {
        // Return the patient ID
        return $patientId;
    } else {
        // No result found for the given appointment ID
        return null;
    }
}
function deleteAllAppointmentsOfOwnerId($ownerId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Start a transaction
    $mysqli->begin_transaction();
    
    // Delete appointments associated with the owner ID
    $queryDeleteAppointments = "DELETE FROM appointment WHERE patientId = ?";
    $stmtDeleteAppointments = $mysqli->prepare($queryDeleteAppointments);
    $stmtDeleteAppointments->bind_param("i", $ownerId);
    $stmtDeleteAppointments->execute();
    
    // Check if any appointments were deleted
    $deletedAppointmentsCount = $stmtDeleteAppointments->affected_rows;
    
    // Commit or rollback the transaction based on the result
    if ($deletedAppointmentsCount > 0) {
        $mysqli->commit();
        return true; // Deletion successful
    } else {
        $mysqli->rollback();
        return false; // No appointments deleted or error occurred
    }
}


//? delete on delete week schedule
function deleteAllAppointmentsByDayAndDoctorId($day, $doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare SQL statement to retrieve appointments for the specified doctor
    $query = "SELECT id, start FROM appointment WHERE doctorId = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $doctorId);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Initialize an array to store appointment IDs to be deleted
    $appointmentsToDelete = [];
    
    // Fetch data and filter appointments by day
    while ($row = $result->fetch_assoc()) {
        // Extract the day of the week from the appointment start date
        $dayOfAppointment = date('l', strtotime($row['start']));

        // Check if the day of the appointment matches the specified day
        if (strtolower($dayOfAppointment) === strtolower($day)) {
            // Add the appointment ID to the array of appointments to be deleted
            $appointmentsToDelete[] = $row['id'];
        }
    }
    
    // Close the statement
    $stmt->close();
    
    // Delete appointments with IDs in the $appointmentsToDelete array
    foreach ($appointmentsToDelete as $appointmentId) {
        // Prepare SQL statement to delete appointment
        $queryDelete = "DELETE FROM appointment WHERE id = ?";
        $stmtDelete = $mysqli->prepare($queryDelete);
        
        if (!$stmtDelete) {
            // Handle the error if the statement preparation fails
            return false;
        }
        
        // Bind the parameter
        $stmtDelete->bind_param("i", $appointmentId);
        
        // Execute the statement
        $stmtDelete->execute();
        
        // Close the statement
        $stmtDelete->close();
    }
    
    // Return true indicating successful deletion
    return true;
}
