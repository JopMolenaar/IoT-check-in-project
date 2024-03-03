<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file the last ten data inserts of the column endTime are gathered from the CheckInOut table 
and the username from an innerjoin of the table User. Every row that is 
found in the table is placed in a table row html element. 
If nothing is found it will echo a string that says No one is found.
*/

include("connect.php");

// Check if the ID already exists in the CheckedIn table
$query = "SELECT ci.id, ci.userId, ci.startTime, ci.endTime, ci.breakStart, ci.breakEnd, u.name 
FROM CheckInOut ci
INNER JOIN User u ON ci.userId = u.id
WHERE ci.endTime IS NOT NULL
ORDER BY endTime DESC LIMIT 10"; // give last 10 rows

$response = $conn->prepare($query);
$response->execute();
$response->store_result();
$response->bind_result($foundId, $founduserId, $foundStartTime, $foundEndTime, $foundBreakStart, $foundBreakEnd, $foundName);

if ($response->num_rows > 0) {
    // Records found where endTime is null
    while($response->fetch()) {
        if(is_null($foundBreakStart)){
            $break = "00:00";
        } else {
            $breakStart = new DateTime($foundBreakStart);
            $breakEnd = new DateTime($foundBreakEnd);
            $breakInterval = $breakStart->diff($breakEnd);
    
            // Format break duration as HH:MM
            $break = $breakInterval->format('%H:%I');
        }
        $rowData = array(
            'name' => $foundName,
            'startTime' => $foundStartTime,
            'endTime' => $foundEndTime,
            'break' => $break
        );
        $responseData[] = $rowData;
    }
    echo json_encode($responseData);
} else {
    $rowData = array(
        'name' => "No one is found.",
        'startTime' => "---",
        'endTime' => "---",
        'break' => "---"
    );
    $responseData[] = $rowData;
    echo json_encode($responseData);
}
?>