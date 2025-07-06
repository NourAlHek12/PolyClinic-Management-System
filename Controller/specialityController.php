<?php
function getAllSpecialities() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, name FROM speciality";
    $stmt = $mysqli->prepare($query);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result variables
    $stmt->bind_result($id, $name);
    
    // Fetch the results into an array of Speciality objects
    $specialities = array();
    while ($stmt->fetch()) {
        $speciality = new Speciality($id, $name);
        $specialities[] = $speciality;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the list of specialities
    return $specialities;
}

function insertSpeciality($name) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "INSERT INTO speciality (name) VALUES (?)";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("s", $name);
    
    // Execute the statement
    try {
        $stmt->execute();
        $stmt->close();
        return true; // Specialty inserted successfully
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to duplicate entry
        if ($e->getCode() == 1062) { // MySQL error code for duplicate entry
            // Handle duplicate entry error
            echo "Error: Specialty '$name' already exists.";
        } else {
            // Handle other errors
            echo "Error: " . $e->getMessage();
        }
        return false;
    }
}

function deleteSpecialty($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Start a transaction
    $mysqli->begin_transaction();

    // Delete appointments of doctors with the specialty
    $queryDeleteAppointments = "DELETE appointment FROM appointment INNER JOIN doctor ON appointment.doctorId = doctor.id WHERE doctor.specialityId = ?";
    $stmtDeleteAppointments = $mysqli->prepare($queryDeleteAppointments);
    $stmtDeleteAppointments->bind_param("i", $id);
    $stmtDeleteAppointments->execute();

    // Delete doctors with the specialty
    $queryDeleteDoctors = "DELETE FROM doctor WHERE specialityId = ?";
    $stmtDeleteDoctors = $mysqli->prepare($queryDeleteDoctors);
    $stmtDeleteDoctors->bind_param("i", $id);
    $stmtDeleteDoctors->execute();

    // Delete the specialty
    $queryDeleteSpecialty = "DELETE FROM speciality WHERE id = ?";
    $stmtDeleteSpecialty = $mysqli->prepare($queryDeleteSpecialty);
    $stmtDeleteSpecialty->bind_param("i", $id);
    $stmtDeleteSpecialty->execute();

    // Commit the transaction
    $mysqli->commit();

    // Check if any deletion was successful
    if ($stmtDeleteAppointments->affected_rows > 0 || $stmtDeleteDoctors->affected_rows > 0 || $stmtDeleteSpecialty->affected_rows > 0) {
        // At least one deletion successful
        return true;
    } else {
        // No deletion successful, rollback the transaction
        $mysqli->rollback();
        return false;
    }
}

function getSpecialityById($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement
    $query = "SELECT id, name FROM speciality WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($specialityId, $name);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Create and return a Speciality object
    return new Speciality($specialityId, $name);
}
function updateSpeciality($specialityId, $name) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement
    $query = "UPDATE `speciality` SET `name`= ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind the parameters
    $stmt->bind_param("si", $name, $specialityId);

    // Execute the statement
    $stmt->execute();


    return true;
}
