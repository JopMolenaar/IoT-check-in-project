<?php

/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file, the user will get a new row in the database table if there is no row without an endtime,
or will get a break time which can be start and end break time, depends on what you already have or not,
or if the user already has a row without an endtime, the endtime will be given to this row.
*/

include("connect.php");

// Check if the ID already exists in the CheckedIn table
$query = "SELECT id, userId, startTime, endTime, breakStart, breakEnd
FROM CheckInOut 
WHERE userId = ? 
ORDER BY id DESC 
LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($foundId, $foundUserId, $foundStartTime, $foundEndTime, $foundBreakStart, $foundBreakEnd);
$stmt->fetch();

$break = $_POST["Break"];

if ($break == true) {
    if ($stmt->num_rows > 0 && is_null($foundEndTime) && (is_null($foundBreakStart) || (!is_null($foundBreakStart) && !is_null($foundBreakEnd)))) {
        // give start break time
        $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
        $currentTime = $currentDate->format('H:i:s');
        $updateQuery = "UPDATE CheckInOut 
        SET breakStart = ? 
        WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $currentTime, $foundId);
        $updateStmt->execute();
        // Close the update statement
        $updateStmt->close();
        $statusMessage = array(
            "success" => true,
            "message" => "Added start break time"
        );
        echo json_encode($statusMessage);
    } elseif ($stmt->num_rows > 0 && is_null($foundEndTime) && !is_null($foundBreakStart) && is_null($foundBreakEnd)) {
        // give end break time
        $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
        $currentTime = $currentDate->format('H:i:s');
        $updateQuery = "UPDATE CheckInOut 
        SET breakEnd = ? 
        WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $currentTime, $foundId);
        $updateStmt->execute();
        // Close the update statement
        $updateStmt->close();
        $statusMessage = array(
            "success" => true,
            "message" => "Getting to work again"
        );
        echo json_encode($statusMessage);
    } else {
        $statusMessage = array(
            "success" => false,
            "message" => "First need to check in"
        );
        echo json_encode($statusMessage);
    }
} elseif ($break == false) {
    if ($stmt->num_rows > 0 && is_null($foundEndTime) && (is_null($foundBreakStart) || (!is_null($foundBreakStart) && !is_null($foundBreakEnd)))) {
        // endtime is null so give endtime, and there is no break or a break start AND end

        $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
        $currentTime = $currentDate->format('Y-m-d H:i:s');
        $updateQuery = "UPDATE CheckInOut 
        SET endTime = ? 
        WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $currentTime, $foundId);
        $updateStmt->execute();
        // Close the update statement
        $updateStmt->close();
        $statusMessage = array(
            "success" => true,
            "message" => "Checked out"
        );
        echo json_encode($statusMessage);
    } elseif ($stmt->num_rows > 0 && is_null($foundEndTime) && !is_null($foundBreakStart) && is_null($foundBreakEnd)) {
        // The break is not fully completed and someone wants to check out
        // give end time and give end break time
        $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
        $currentTime = $currentDate->format('H:i');

        $currentTimeDate = $currentDate->format('Y-m-d H:i:s');

        $updateQuery = "UPDATE CheckInOut 
        SET breakEnd = ?, endTime = ? 
        WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssi", $currentTime, $currentTimeDate, $foundId);
        $updateStmt->execute();
        // Close the update statement
        $updateStmt->close();
        $statusMessage = array(
            "success" => true,
            "message" => "Checked out"
        );
        echo json_encode($statusMessage);
    } else {
        $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
        $startTime = $currentDate->format('Y-m-d H:i:s');

        // Prepare SQL command with placeholders
        $stmt = $conn->prepare("INSERT INTO CheckInOut (userId, startTime) VALUES (?, ?)");
        // Bind parameters (i = integer, s = string)
        $stmt->bind_param("is", $id, $startTime);

        if ($stmt->execute()) {
            $status = array(
                "name" => $name,
                "success" => true,
                "message" => "Added to database"
            );
            echo json_encode($status);
        } else {
            $statusMessage = array(
                "success" => false,
                "message" => "Error occurred"
            );
            echo json_encode($statusMessage);
        }
        $stmt->close();
    }
}

?>



 