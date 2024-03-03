<?php
/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 02-11-2023
Description: In this file I bypass CORS restrictions because this gave me errors when sending 
a http request to my embedded device. 
*/

header("Access-Control-Allow-Origin: *");

$url = 'http://192.168.2.16/test'; // Replace this with the actual URL you want to access

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);

curl_close($ch);