<?php
function addRoom($number,$desc) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Check if the room already exists
    $checkQuery = "SELECT id FROM room WHERE number = ?";
    $checkStmt = $mysqli->prepare($checkQuery);
    $checkStmt->bind_param("s", $number);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    // If a room with the same number already exists, return false
    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        return false;
    }
    
    // Prepare the SQL statement
    $query = "INSERT INTO room (number,`desc`) VALUES (?,?)";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("ss", $number,$desc);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the room was added successfully
    if ($stmt->affected_rows > 0) {
        // Room added successfully
        $stmt->close();
        return true; 
    } else {
        // Failed to add room
        $stmt->close();
        return false;
    }
}

function deleteRoom($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "DELETE FROM room WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the room was deleted successfully
    if ($stmt->affected_rows > 0) {
        // Room deleted successfully
        $stmt->close();
        return true;
    } else {
        // Failed to delete room
        $stmt->close();
        return false;
    }
}

function getRooms() {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, number,`desc` FROM room";
    $stmt = $mysqli->prepare($query);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Fetch data
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = new Room($row['id'], $row['number'],$row['desc']);
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the result
    return $rooms;
}

function getRoomById($id)
{
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT id, number, `desc` FROM room WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind the parameter
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Fetch data
    $room = [];
    while ($row = $result->fetch_assoc()) {
        $room[] = new Room($row['id'], $row['number'], $row['desc']);
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the result
    return $room[0];
}

function updateRoom($number, $desc, $id)
{
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "UPDATE room SET number = ?, `desc` = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("ssi", $number, $desc, $id);
    
    // Execute the statement
    $result = $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
    // Return the result
    return $result;
}
