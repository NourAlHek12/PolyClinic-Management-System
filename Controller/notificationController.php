<?php
function getNotificationsByPatientId($patientId) {
    // Get database connection
    $mysqli = SingletonConnectionToDb::getInstance()->getConnection();

    // Prepare SQL statement to retrieve notifications for the given patient
    $query = "SELECT * FROM notification ,appointment WHERE notification.appointmentId = appointment.id
    AND appointment.patientId = ?
    ";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle query preparation error
        error_log("Notification Retrieval Query Preparation Error: " . $mysqli->error);
        return false;
    }

    // Bind parameter
    $stmt->bind_param("i", $patientId);

    // Execute the statement
    if (!$stmt->execute()) {
        // Handle query execution error
        error_log("Notification Retrieval Query Execution Error: " . $stmt->error);
        return false;
    }

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an array to store notification objects
    $notifications = array();

    // Fetch notifications and create Notification objects
    while ($row = $result->fetch_assoc()) {
        // Create a Notification object for each row and add it to the array
        $notification = new Notification(
            $row['id'],
            $row['patientId'],
            $row['content'],
            $row['createdAt']
        );
        $notifications[] = $notification;
    }

    // Close the statement
    $stmt->close();

    // Return the array of notifications
    return $notifications;
}
