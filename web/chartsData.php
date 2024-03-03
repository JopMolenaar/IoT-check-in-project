<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 28-10-2023
Description: In this file I get all the data from the CheckInOut table and place it in an array full of objects
*/

include("connect.php");

// get current data and dat from 30 days ago
$currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam')); 
$currentTime = $currentDate->format('Y-m-d H:i:s');
$currentDate->sub(new DateInterval('P30D'));
$lastMonthTime = $currentDate->format('Y-m-d H:i:s');


// SQL query to get data where endTime is greater than last month
$query = "SELECT ci.id, ci.userId, ci.startTime, ci.endTime, ci.breakStart, ci.breakEnd, u.name 
FROM CheckInOut ci
INNER JOIN User u ON ci.userId = u.id
WHERE ci.endTime IS NOT NULL 
AND ci.endTime >= '$lastMonthTime'
AND ci.endTime <= '$currentTime'";

$response = $conn->prepare($query);
$response->execute();
$response->store_result();
$response->bind_result($foundId, $foundUserId, $foundStartTime, $foundEndTime, $foundBreakStart, $foundBreakEnd, $foundName);

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
            'StatusString' => "Data found",
            'id' => $foundId,
            'userId' => $foundUserId,
            'name' => $foundName,
            'startTime' => $foundStartTime,
            'endTime' => $foundEndTime,
            'break' => $break,
        );
        $responseData[] = $rowData;
    }
    echo json_encode($responseData);
} else {
    $rowData = array(
        'StatusString' => "No one is found.",
    );
    $responseData[] = $rowData;
    echo json_encode($responseData);
}
?>