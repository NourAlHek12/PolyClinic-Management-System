<?php
function insertDoctor($firstName, $lastName, $gmail, $password, $picture, $phone, $specialityId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "INSERT INTO doctor (firstName, lastName, gmail, password, picture, phone, specialityId) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameters
    $stmt->bind_param("ssssssi", $firstName, $lastName, $gmail, $password, $picture, $phone, $specialityId);
    
    // Execute the statement
    try {
        $stmt->execute();
        $stmt->close();
        return true; // Doctor inserted successfully
    } catch (mysqli_sql_exception $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getAllDoctors() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement to select doctors with their specialities
    $query = "SELECT d.id, d.firstName, d.lastName, d.gmail, d.password, d.picture, d.phone, s.id as specialityId, s.name as specialityName
              FROM doctor d
              INNER JOIN speciality s ON d.specialityId = s.id";
    $stmt = $mysqli->prepare($query);

    // Execute the statement
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Initialize array to store Doctor objects
    $doctors = [];

    // Fetch doctors and create Doctor objects
    while ($row = $result->fetch_assoc()) {
        // Create Speciality object for the doctor
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);

        // Create Doctor object and add it to the array
        $doctor = new Doctor(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['gmail'],
            $row['password'],
            $row['picture'],
            $row['phone'],
            $speciality
        );
        $doctors[] = $doctor;
    }

    // Close the statement
    $stmt->close();

    // Return the array of Doctor objects
    return $doctors;
}

function getAllDoctorsBySpecialtyId($specialtyId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement
    $query = "SELECT d.id, d.firstName, d.lastName, d.gmail, d.password, d.picture, d.phone, s.id as specialityId, s.name as specialityName
              FROM doctor d
              INNER JOIN speciality s ON d.specialityId = s.id
              WHERE d.specialityId = ?";
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $specialtyId);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an array to store Doctor objects
    $doctors = [];

    // Fetch doctors' information and create Doctor objects
    while ($row = $result->fetch_assoc()) {
        // Create a Speciality object
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);

        // Create a new Doctor object with the Speciality object and add it to the array
        $doctor = new Doctor(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['gmail'],
            $row['password'],
            $row['picture'],
            $row['phone'],
            $speciality
        );
        $doctors[] = $doctor;
    }

    // Close the statement
    $stmt->close();

    // Return the array of Doctor objects
    return $doctors;
}



function getDoctorsBasedOnFirstNameOrLastName($name) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT 
                d.id, 
                d.firstName, 
                d.lastName, 
                d.gmail, 
                d.password, 
                d.picture, 
                d.phone, 
                s.id as specialityId, 
                s.name as specialityName 
              FROM 
                doctor d 
              INNER JOIN 
                speciality s ON d.specialityId = s.id 
              WHERE 
                d.firstName LIKE CONCAT('%', ?, '%') OR d.lastName LIKE CONCAT('%', ?, '%')";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameters
    $stmt->bind_param("ss", $name, $name);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Fetch data
    $doctors = [];

    // Fetch doctors and create Doctor objects
    while ($row = $result->fetch_assoc()) {
        // Create Speciality object for the doctor
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);

        // Create Doctor object and add it to the array
        $doctor = new Doctor(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['gmail'],
            $row['password'],
            $row['picture'],
            $row['phone'],
            $speciality
        );
        $doctors[] = $doctor;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the result
    return $doctors;
}



function deleteDoctor($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Start a transaction
    $mysqli->begin_transaction();

    // Delete all appointments associated with the doctor
    $queryDeleteAppointments = "DELETE FROM appointment WHERE doctorId = ?";
    $stmtDeleteAppointments = $mysqli->prepare($queryDeleteAppointments);
    $stmtDeleteAppointments->bind_param("i", $id);
    $stmtDeleteAppointments->execute();

    // Delete notifications related to the deleted appointments
    // Assuming there's a table named notifications with appointmentId as a foreign key
    // Delete notifications for the appointments being deleted
    $queryDeleteNotifications = "DELETE FROM notification WHERE appointmentId IN (SELECT id FROM appointment WHERE doctorId = ?)";
    $stmtDeleteNotifications = $mysqli->prepare($queryDeleteNotifications);
    $stmtDeleteNotifications->bind_param("i", $id);
    $stmtDeleteNotifications->execute();

    // Delete the doctor
    $queryDeleteDoctor = "DELETE FROM doctor WHERE id = ?";
    $stmtDeleteDoctor = $mysqli->prepare($queryDeleteDoctor);
    $stmtDeleteDoctor->bind_param("i", $id);
    $stmtDeleteDoctor->execute();

    // Commit the transaction
    $mysqli->commit();

    // Check if all deletions were successful
    if ($stmtDeleteAppointments->affected_rows > 0 || $stmtDeleteDoctor->affected_rows > 0) {
        // All deletions successful
        return true;
    } else {
        // At least one deletion failed, rollback the transaction
        $mysqli->rollback();
        return false;
    }
}





function getDoctorInfo($doctorId) {
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare SQL statement to retrieve doctor information
    $query = "SELECT * FROM doctor WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind parameter
    $stmt->bind_param("i", $doctorId);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if doctor exists
    if ($result->num_rows === 1) {
        // Fetch doctor information
        $row = $result->fetch_assoc();
        
        // Create a Doctor object
        $doctor = new Doctor(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['gmail'],
            $row['password'],
            $row['picture'],
            $row['phone'],
            null
        );
        
        return $doctor;
    } else {
        // Doctor not found
        return null;
    }
}

function getDoctorById($doctorId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement to select a doctor with their speciality by ID
    $query = "SELECT d.id, d.firstName, d.lastName, d.gmail, d.password, d.picture, d.phone, s.id as specialityId, s.name as specialityName
              FROM doctor d
              INNER JOIN speciality s ON d.specialityId = s.id
              WHERE d.id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind parameter
    $stmt->bind_param("i", $doctorId);

    // Execute the statement
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Fetch the doctor
    if ($row = $result->fetch_assoc()) {
        // Create Speciality object for the doctor
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);

        // Create Doctor object
        $doctor = new Doctor(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['gmail'],
            $row['password'],
            $row['picture'],
            $row['phone'],
            $speciality
        );

        // Close the statement
        $stmt->close();

        // Return the Doctor object
        return $doctor;
    } else {
        // Doctor not found
        return null;
    }
}

function updateDoctor($doctorId, $firstName, $lastName, $gmail, $phone, $specialityId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement to update the doctor's information
    $query = "UPDATE doctor SET firstName = ?, lastName = ?, gmail = ?, phone = ?, specialityId = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind parameters
    $stmt->bind_param("ssssii", $firstName, $lastName, $gmail, $phone, $specialityId, $doctorId);

    // Execute the statement
    $result = $stmt->execute();

    // Close the statement
    $stmt->close();

    // Return true if the update was successful, otherwise return false
    return $result;
}

function doctorUpdatePassword($doctorId, $newPassword) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "UPDATE doctor SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
        
    // Bind the parameters
    $stmt->bind_param("si", $newPassword, $doctorId);
    
    // Execute the statement
    $result = $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
    return $result;
}
