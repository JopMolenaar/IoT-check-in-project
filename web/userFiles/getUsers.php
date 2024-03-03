<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file all data is gathered form the table User and for each row of 
data found it will place it in a table row and echo it
*/

include("../connect.php");

$query = "SELECT * FROM User";
$response = mysqli_query($conn, $query);

$responseData = array(); // Initialize an empty array to store data

while($i = mysqli_fetch_assoc($response)) {
    $rowData = array(
        'name' => $i['name'],
        'cardId' => $i['card_id'],
        'id' => $i['id']
    );
    $responseData[] = $rowData;
}

echo json_encode($responseData);
?>
