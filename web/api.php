<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file, data is sent from the embedded device to this API. 
The user will be found with his/her card ID, and this data will be given to another file addCheckIn.php
If the user is not found, it will send a string back to the embedded device with "No employee".
*/

include("connect.php");

$cardId = $_POST["cardId"];

// Use prepared statements to prevent SQL injection
$query = "SELECT name, card_id, id FROM User WHERE card_id = ?";
$stmt = $conn->prepare($query);
// Bind the parameter (cardId)
$stmt->bind_param("s", $cardId);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows === 0) {
    $statusMessage = array(
        "success" => false,
        "message" => "No employee"
    );
    echo json_encode($statusMessage);

} else {
    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $id = $row['id'];
    }
    include("addCheckIn.php");
}
?>
