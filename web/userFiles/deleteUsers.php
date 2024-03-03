<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file data is received by a POST request and will 
delete an user from where the id is the same as the id out of the POST request.
*/

include("../connect.php");

    $id=$_POST['id'];
    $sql = "DELETE FROM User WHERE id='$id'";
    $delete = mysqli_query($conn, $sql);
?>