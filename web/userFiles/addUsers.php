<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file data is received by a POST request and placed in the table User
*/

include("../connect.php");

        $name = $_POST["name"];
        $card_id = $_POST["card_id"];

        // prepares sql command, the ?'s are placeholders
        $stmt = $conn->prepare("INSERT INTO User (name, card_id) VALUES (?, ?)");
        // s = string
        $stmt->bind_param("ss", $name, $card_id);
        if ($stmt->execute()) {
            $statusMessage = array(
                "success" => true,
                "message" => "added user"
            );
            echo json_encode($statusMessage);
        } else {
            $statusMessage = array(
                "success" => false,
                "message" => "Error occurred"
            );
            echo json_encode($statusMessage);
        }
        $stmt->close();
?>