/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: This file uses AJAX to run a php file that sends a http request to my embedded device.
I dont get any respond data.
*/

const testBtn = document.getElementById("testBtn");

testBtn.addEventListener("click", () => {
  $.ajax({
    type: "GET",
    url: "../proxy.php",
    success: function (response) {
      console.log("Tested Oled and Led's on WeMos");
    },
    error: function (xhr, status, error) {
      console.error("Error occurred:", error);
    },
  });
});
