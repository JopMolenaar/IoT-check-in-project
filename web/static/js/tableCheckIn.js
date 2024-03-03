/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: This file handles AJAX functions to load data in a certain section. In the loadTable() it also calculates the time between the start time and current time
*/

const halfSecond = 500;
const threeSeconds = 3000;
const milliSecondsInHour = 3600000;
const milliSecondsInMinute = 60000;

const loadTable = () => {
  $.ajax({
    type: "POST",
    url: "../getCheckInTable.php",
    data: {},
    success: function (response) {
      const checkInTable = document.querySelector("#autoLoadCheckIn");
      const firstRow = checkInTable.querySelector("tbody tr");
      // look if the table has rows, if no: dont load history, if yes, load history

      setTimeout(() => {
        if (firstRow) {
          loadHistoryTable();
        }
      }, halfSecond);
      // If someone is checked in, load the table every 500 ms.

      const data = JSON.parse(response);

      const tableRows = data.map((row) => {
        if (row.name === "Noone is checked in") {
          // if noone is checked in, show this:
          return `<tr>
          <td>Noone is checked in</td>
          <td>---</td>      
          </tr>`;
        } else {
          // calculate the time differance between start time and current time.
          const parts = row.startTime.split(/\s+/); // split things I don't need in starttime
          let timeStart = parts[1].slice(0, -3); // make starttime ready for insert in setHours function
          let timeEnd = row.curTime;
          let dateStart = parts[0].replaceAll("-", "/");
          var currentTime = new Date();
          var year = currentTime.getFullYear();
          dateStart = dateStart.replace(`${year}/`, ""); // delete year
          let checkInTime;

          const currentDate = new Date();
          const month = String(currentDate.getMonth() + 1).padStart(2, "0"); // Adds leading zero if needed
          const day = String(currentDate.getDate()).padStart(2, "0"); // Adds leading zero if needed
          const formattedDate = `${month}/${day}`;

          // Splitting time string into hours and minutes
          const time1Arr = timeStart.split(":");
          const time2Arr = timeEnd.split(":");

          // Creating Date objects with the same date and the provided times
          const date1 = new Date();
          date1.setHours(time1Arr[0], time1Arr[1]);
          const date2 = new Date();
          date2.setHours(time2Arr[0], time2Arr[1]);

          // Calculating the time difference in milliseconds
          const timeDiffMillisec = Math.abs(date2 - date1);

          // Converting milliseconds to hours and minutes
          const hours = Math.floor(timeDiffMillisec / milliSecondsInHour);
          const minutes = Math.floor(
            (timeDiffMillisec % milliSecondsInHour) / milliSecondsInMinute
          );
          console.log(dateStart, formattedDate);
          if (dateStart != formattedDate) {
            checkInTime = `+1 day`;
          } else {
            checkInTime = `${hours} hours and ${minutes} minutes`;
          }

          return `<tr>
                <td>${row.name}</td>
                <td>${checkInTime}</td>      
                </tr>`;
        }
      });
      $("#autoLoadCheckIn").html(tableRows.join(""));
    },
  });
};
loadTable();
setInterval(loadTable, threeSeconds);

const loadHistoryTable = () => {
  $.ajax({
    type: "POST",
    url: "../getHistoryTable.php",
    data: {},
    success: function (response) {
      const historyData = JSON.parse(response);

      const tableRows = historyData.map((row) => {
        return `<tr>
                    <td>${row.name}</td>
                    <td>${row.startTime}</td>
                    <td>${row.endTime}</td>
                    <td>${row.break}</td>
                </tr>`;
      });
      $("#historyTable").html(tableRows.join(""));
    },
  });
};
loadHistoryTable();
