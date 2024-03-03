<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file all data is gathered from the CheckInOut table 
and the username from an innerjoin of the table User. Every row that is 
found in the table is placed in a table row html element. 
If nothing is found it will echo an empty table row.
*/

include("connect.php");

// Check if the ID already exists in the CheckedIn table
$query = "SELECT ci.id, ci.userId, ci.startTime, ci.endTime, u.name 
FROM CheckInOut ci
INNER JOIN User u ON ci.userId = u.id
WHERE ci.endTime IS NULL
ORDER BY ci.id DESC";

$response = $conn->prepare($query);
$response->execute();
$response->store_result();
$response->bind_result($foundId, $founduserId, $foundStartTime, $foundEndTime, $foundName);

$currentDateTime = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 

if ($response->num_rows > 0) {
    // Records found where endTime is null
    while($response->fetch()) {
        $rowData = array(
            'name' => $foundName,
            'startTime' => $foundStartTime,
            'curDate' => $currentDateTime->format("m/d"),
            'curTime' => $currentDateTime->format("H:i")
        );
        $responseData[] = $rowData;
    }
    echo json_encode($responseData);
} else {
    $rowData = array(
        'name' => "Noone is checked in",
        'startTime' => "---",
        'curDate' => "---",
        'curTime' => "---"
    );
    $responseData[] = $rowData;
echo json_encode($responseData);
}
?>