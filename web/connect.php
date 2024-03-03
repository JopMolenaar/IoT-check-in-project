<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: In this file a variable is made with a myslqi command to make connection with the database. 
*/

// Consists out of the docker name, the username for the database, password for the database and the table name.
$conn = new mysqli("mariadb", "root", "7YKyE8R2AhKzswfN", "timeRegistration");
?>