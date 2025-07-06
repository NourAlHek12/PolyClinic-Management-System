<?php
function getSchedule($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT w.id AS scheduleId, w.day, w.target, w.start, w.end, w.roomId AS roomId, room.number, `desc`, d.id AS doctorId, d.firstName, d.lastName, d.gmail, d.picture, d.phone, s.id AS specialityId, s.name AS specialityName 
    FROM weekschedule w 
    INNER JOIN doctor d ON w.doctorId = d.id 
    INNER JOIN speciality s ON d.specialityId = s.id
    INNER JOIN room ON w.roomId = room.id
    WHERE w.doctorId = ?
    ";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameters
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Initialize an array to store WeekSchedule objects
    $schedule = [];
    
    // Fetch each row and create a WeekSchedule object
    while ($row = $result->fetch_assoc()) {
        // Create a Speciality object for the doctor's speciality
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);
        
        // Create a Doctor object with the fetched properties
        $doctor = new Doctor($row['doctorId'], $row['firstName'], $row['lastName'], $row['gmail'], "", $row['picture'], $row['phone'], $speciality);
        
        // Create a Room object with the fetched room properties
        $room = new Room($row['roomId'], $row['number'],$row['desc']);
        
        // Create a WeekSchedule object with the doctor, day, start, end, and room
        $weekSchedule = new WeekSchedule($row['scheduleId'], $doctor, $row['day'], $row['target'], $row['start'], $row['end'], $room);
        
        // Append the WeekSchedule object to the schedule array
        $schedule[] = $weekSchedule;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the schedule array
    return $schedule;
}


function insertSchedule($doctorId, $day, $shift, $start, $end, $roomId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // checking if schedule exists already for this doctor in this day in this shift
    $query = "SELECT * FROM weekschedule WHERE doctorId = ? AND day = ? AND target = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return false; // Return false if statement preparation fails
    }
    $stmt->bind_param("iss", $doctorId, $day, $shift);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        return false; // Return false if the schedule already exists
    }
    $stmt->close();

    // checking if already a doctor have the same schedule (same room id) in this day in this shift
    $query = "SELECT * FROM weekschedule WHERE roomId = ? AND day = ? AND target = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return false; // Return false if statement preparation fails
    }
    $stmt->bind_param("iss", $roomId, $day, $shift);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        return false; // Return false if another doctor already has the same schedule
    }
    $stmt->close();

    // Inserting schedule
    $query = "INSERT INTO weekschedule (doctorId, day, target, start, end, roomId) 
              VALUES ($doctorId, '$day','$shift',' $start', '$end', $roomId)";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return false; // Return false if statement preparation fails
    }
    $result = $stmt->execute();
    $stmt->close();
    return $result; // Return the result of the execution
}


function deleteSchedule($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "DELETE FROM weekschedule WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $result = $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
    // Return the result of the execution
    return $result;
}

function getScheduleByDay($id,$day) {//monday
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare the SQL statement
    $query = "SELECT w.id AS scheduleId,
              w.day,w.target, w.start, w.end, w.roomId AS roomId,
              room.number,
              room.desc as `description`,
              d.id AS doctorId, d.firstName, d.lastName, d.gmail, d.picture, d.phone, s.id AS specialityId, s.name AS specialityName 
              FROM weekschedule w 
              INNER JOIN doctor d ON w.doctorId = d.id 
              INNER JOIN speciality s ON d.specialityId = s.id
              INNER JOIN room ON w.roomId = room.id
              WHERE w.doctorId = ? AND w.day = '$day'
            ";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameters
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Initialize an array to store WeekSchedule objects
    $schedule = [];
    
    // Fetch each row and create a WeekSchedule object
    while ($row = $result->fetch_assoc()) {
        // Create a Speciality object for the doctor's speciality
        $speciality = new Speciality($row['specialityId'], $row['specialityName']);
        
        // Create a Doctor object with the fetched properties
        $doctor = new Doctor($row['doctorId'], $row['firstName'], $row['lastName'], $row['gmail'], "", $row['picture'], $row['phone'], $speciality);
        
        // Create a Room object with the fetched room properties
        $room = new Room($row['roomId'], $row['number'],$row['description']);
        
        // Create a WeekSchedule object with the doctor, day, start, end, and room
        $weekSchedule = new WeekSchedule($row['scheduleId'], $doctor, $row['day'], $row['target'], $row['start'], $row['end'], $room);
        
        // Append the WeekSchedule object to the schedule array
        $schedule[] = $weekSchedule;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the schedule array
    return $schedule;
}
function getDayOfSchedule($id) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();
    
    // Prepare SQL statement to retrieve the day of the schedule
    $query = "SELECT day FROM weekschedule WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    
    if (!$stmt) {
        // Handle the error if the statement preparation fails
        return false;
    }
    
    // Bind the parameter
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result variable
    $stmt->bind_result($day);
    
    // Fetch the result
    $stmt->fetch();
    
    // Close the statement
    $stmt->close();
    
    // Return the day of the schedule
    return $day;
}

