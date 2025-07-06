<?php
function managerLogin($id, $password) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id FROM manger WHERE id = ? AND password = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameters
    $stmt->bind_param("ss", $id, $password);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
    
    // Check if a row is returned
    if ($stmt->num_rows == 1) {
        // Manager authenticated successfully
            
        // Close the statement
        $stmt->close();
        return true;
        
    } else {
        // Manager not found or password incorrect
        // Close the statement
        $stmt->close();
        return false;
    }

}

function secLogin($phone, $password) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, name FROM secretary WHERE phone = ? AND password = ?";
    $stmt = $mysqli->prepare($query);
    
    // Check if statement preparation failed
    if (!$stmt) {
        // Handle the error
        error_log("secLogin: Failed to prepare statement: " . $mysqli->error);
        return false;
    }
    
    // Bind the parameters
    $stmt->bind_param("ss", $phone, $password);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
    
    // Check if a row is returned
    if ($stmt->num_rows == 1) {
        // Fetch the result
        $stmt->bind_result($secId, $name);
        $stmt->fetch();
        
        // Store the secretary ID in the session
        $_SESSION['sec-id'] = $secId;
        $_SESSION['id'] = $secId;
        $_SESSION['name'] = $name;
        
        // Close the statement
        $stmt->close();
        
        // Secretary authenticated successfully
        return true;
    } else {
        // Close the statement
        $stmt->close();
        
        // Secretary not found or password incorrect
        return false;
    }
}

function docLogin($gmail, $password) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, firstName, lastName FROM doctor WHERE gmail = ? AND password = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameters
    $stmt->bind_param("ss", $gmail, $password);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
    
    // Check if a row is returned
    if ($stmt->num_rows == 1) {
        // Fetch the result
        $stmt->bind_result($id, $firstName, $lastName);
        $stmt->fetch();
        
        // Close the statement
        $stmt->close();
        
        // Store the full name in the session
        $_SESSION['name'] = $firstName . " " . $lastName;
        $_SESSION['doc-id'] = $id;
        
        // Return the doctor's id
        return $id;
    } else {
        // Close the statement
        $stmt->close();
        
        // Doctor not found or password incorrect
        return null;
    }
}

function patientLogin($gmail, $password) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, password,firstName,lastName,blocked FROM patient WHERE gmail = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("s", $gmail);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
    
    // Check if a row is returned
    if ($stmt->num_rows == 1) {
        // Bind the result to variables
        $stmt->bind_result($id, $hashedPassword, $firstName, $lastName,$blocked);
        
        // Fetch the result
        $stmt->fetch();
        if($blocked){
            return false;
        }
        // Verify the entered password against the stored hash
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            // Close the statement
            $stmt->close();
            
            // Return the user ID
            $_SESSION['name'] = $firstName." ".$lastName;
            return $id;
        } else {
            // Password is incorrect
            // Close the statement
            $stmt->close();
            
            // Return null
            return null;
        }
    } else {
        // User not found
        // Close the statement
        $stmt->close();
        
        // Return null
        return null;
    }
}

function patientSignUp($fn, $ln, $phone, $email, $password)
{
    // Validate input parameters
    if (empty($fn) || empty($ln) || empty($phone) || empty($email) || empty($password)) {
        // Return false if any required parameter is empty
        return false;
    }

    // Hash the password

    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Check if email already exists
    $queryCheckEmail = "SELECT id FROM patient WHERE gmail = ?";
    $stmtCheckEmail = $mysqli->prepare($queryCheckEmail);
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $resultCheckEmail = $stmtCheckEmail->get_result();

    // If email already exists, return false
    if ($resultCheckEmail->num_rows > 0) {
        // Email already exists, return false indicating sign-up failure
        return false;
    }

    // Prepare SQL statement to insert new patient
    $query = "INSERT INTO patient (firstName, lastName, phone, gmail, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    // Bind parameters
    $stmt->bind_param("sssss", $fn, $ln, $phone, $email, $password);

    // Execute the statement
    $result = $stmt->execute();

    // Check if the insertion was successful
    if ($result) {
        // Return true if patient sign-up was successful
        return true;
    } else {
        // Return false if an error occurred during sign-up
        return false;
    }
}



