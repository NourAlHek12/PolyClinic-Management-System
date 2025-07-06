<?php
function getAllSecrataries() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id,name, phone,password FROM secretary";
    $stmt = $mysqli->prepare($query);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result variables
    $stmt->bind_result($id,$name, $phone, $password);
    
    // Fetch the results into an array of Speciality objects
    $sec = array();
    while ($stmt->fetch()) {
        $s = new Secretary($id,$name,$phone,$password);
        $sec[] = $s;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the list of specialities
    return $sec;
}
function getSecretariesByName($name) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, name, phone, password 
    FROM secretary
    WHERE name LIKE CONCAT('%', ?, '%')";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("s", $name);
    
    // Bind the result variables
    $stmt->bind_result($id, $secName, $phone, $password);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $secretaries = [];
    
    // Fetch data
    while ($stmt->fetch()) {
        $s = new Secretary($id, $secName, $phone, $password);
        $secretaries[] = $s;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the result
    return $secretaries;
}


function insertSecretary($name, $phone, $password) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "INSERT INTO `secretary`(`name`, `phone`, `password`)
     VALUES (?,?,?)";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("sis",$name, $phone, $password);
    
    // Execute the statement
    try {
        $stmt->execute();
        $stmt->close();
        return true; // Specialty inserted successfully
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to duplicate entry
        if ($e->getCode() == 1062) { // MySQL error code for duplicate entry
            // Handle duplicate entry error
            echo "Error: Specialty already exists.";
        } else {
            // Handle other errors
            echo "Error: " . $e->getMessage();
        }
        return false;
    }
}
function deleteSecretary($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare the SQL statement
    $query = "DELETE FROM secretary WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Return true if deletion was successful
        return true;
    } else {
        // Return false if an error occurred
        return false;
    }
    
    // Close the statement
}

function getSecretariesById($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, name, phone, password FROM secretary WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Check if statement preparation failed
    if (!$stmt) {
        // Handle the error
        error_log("getSecretariesById: Failed to prepare statement: " . $mysqli->error);
        return null;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result variables
    $stmt->bind_result($secId, $secName, $phone, $password);
    
    // Fetch the result
    $stmt->fetch();
    
    // Close the statement
    $stmt->close();
    
    // Check if a secretary was found
    if (!empty($secId)) {
        // Create and return a Secretary object
        return new Secretary($secId, $secName, $phone, $password);
    } else {
        // Secretary not found
        return null;
    }
}

function updateSecretary($secId, $secName, $phone) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "UPDATE secretary SET name = ?, phone = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("ssi", $secName, $phone, $secId);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Update successful
        return true;
    } else {
        // Update failed
        return false;
    }
}
function secretaryUpdatePassword($secId, $newPassword) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "UPDATE secretary SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Hash the new password before updating
    
    // Bind the parameters
    $stmt->bind_param("si", $newPassword, $secId);
    
    // Execute the statement
    $result = $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
    return true;
}
