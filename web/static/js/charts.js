/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 06-11-2023
Description: This file includes AJAX functions with the logic of making the data ready and giving 
this to the dynamic function from chart.js that makes graphs.
*/

const workWeekSection = document.getElementById("workWeek");
const workMonthSection = document.getElementById("workMonth");
const lunchMonthSection = document.getElementById("lunchWeek");
let workedHoursMonth = 0;
let workedHoursWeek = 0;
let lunchMinutesMonth = 0;

const makeChart = (data, labels, label, section) => {
  new Chart(section, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: label,
          data: data,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
};

const loadTable = () => {
  $.ajax({
    type: "POST",
    url: "../chartsData.php",
    data: {},
    success: function (response) {
      const chartData = JSON.parse(response);
      let idArray = [];
      let usersArray = [];
      chartData.forEach((dataRow) => {
        if (!idArray.includes(dataRow.userId)) {
          idArray.push(dataRow.userId);

          let userObject = {
            name: dataRow.name,
            userId: dataRow.userId,
            workedHoursMonth: workedHoursMonth,
            workedHoursWeek: workedHoursWeek,
            lunchMinutesMonth: lunchMinutesMonth,
          };
          usersArray.push(userObject);
        }

        let userObject = usersArray.find(
          (user) => user.userId === dataRow.userId
        );

        // Function to convert HH:mm to total minutes for break minutes
        function durationToMinutes(duration) {
          let [hours, minutes] = duration.split(":");
          return parseInt(hours) * 60 + parseInt(minutes);
        }
        // add break minutes in user object
        userObject.lunchMinutesMonth += durationToMinutes(dataRow.break);

        // setup time from last week
        let currentDateLastWeek = new Date();
        currentDateLastWeek.setDate(currentDateLastWeek.getDate() - 7);
        function formatDate(date) {
          let year = date.getFullYear();
          let month = String(date.getMonth() + 1).padStart(2, "0"); // Month is zero-based
          let day = String(date.getDate()).padStart(2, "0");
          let hours = String(date.getHours()).padStart(2, "0");
          let minutes = String(date.getMinutes()).padStart(2, "0");
          let seconds = String(date.getSeconds()).padStart(2, "0");
          return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
        // Format the current date from last week
        let formattedDateLastWeek = formatDate(currentDateLastWeek);

        // function to calculate the difference between the two times
        const getTimeDifference = (time1, time2) => {
          let startTime = new Date(`${time1}`);
          let endTime = new Date(`${time2}`);
          // Calculate the difference in milliseconds
          let timeDifference = endTime - startTime;
          let timeDifferenceInHours = timeDifference / (1000 * 60 * 60);
          return timeDifferenceInHours;
        };

        // if the start time is not more then a week ago
        if (dataRow.startTime > formattedDateLastWeek) {
          userObject.workedHoursWeek += getTimeDifference(
            dataRow.startTime,
            dataRow.endTime
          );
        }

        userObject.workedHoursMonth += getTimeDifference(
          dataRow.startTime,
          dataRow.endTime
        );
      });

      // console.log(usersArray);

      let namesArray = [];
      let workedHoursArrayMonth = [];
      let workedHoursArrayWeek = [];
      let lunchMinutesArrayMonth = [];

      usersArray.forEach((user) => {
        namesArray.push(user.name);
        workedHoursArrayMonth.push(user.workedHoursMonth);
        workedHoursArrayWeek.push(user.workedHoursWeek);
        lunchMinutesArrayMonth.push(user.lunchMinutesMonth);
      });
      const labelHours = "Hours per person";
      const labelMinutes = "Minutes per person";

      makeChart(
        workedHoursArrayMonth,
        namesArray,
        labelHours,
        workMonthSection
      );
      makeChart(workedHoursArrayWeek, namesArray, labelHours, workWeekSection);
      makeChart(
        lunchMinutesArrayMonth,
        namesArray,
        labelMinutes,
        lunchMonthSection
      );
    },
  });
};
loadTable();
