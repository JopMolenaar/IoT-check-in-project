# Market research implementation

On this page I will tel you how I implemented the research I have done on the <a href="../marketResearch">research page</a>.

## Implementation

I first read some documentation about chart.js and used the template on their website to get started. I figured out how it was working and tried to make it work with my AJAX code.

After I did that, I started writing the logic. Graphs consist out of data and that data comes out of the database. With that data you can calculate multiple things. The idea was to have three graphs with statistics about how many hours a person worked this week and month. I also wanted to add a graph where you can see how many break hours a person had in a week.

The piece of code was pretty simple. I wanted three (minimal) graphs which were all bar charts. I also did not wanted a lot of code duplication so I rewrote the piece of code in such a way that is was flexible. This was the code:

First of all you need to copy thius link and place it under in the body.

```js
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

And this is the template that I made a little more dynamic by using parameters.

```js
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
```

The parameters are the data numbers, the lable for each data number, the piece of text for the legend and the section where the graph should come.

I fire this function in an ajax function where I call a php file who brings all the data out of the data base.
In that funcion I made some other functions to calculate the data (hours of work per week or month, and breaks of course) per person.
These are pieces of code out of that code:

First I make a user object for each user that is found, I do that by looking for the user id and if that user id is already seen is does not make another one.

```js
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
```

In this function I calculate the amount of time a person has had their lunch break in minutes in the month.

```js
// Function to convert HH:mm to total minutes for break minutes
function durationToMinutes(duration) {
  let [hours, minutes] = duration.split(":");
  return parseInt(hours) * 60 + parseInt(minutes);
}
// add break minutes in user object
userObject.lunchMinutesMonth += durationToMinutes(dataRow.break);
```

In this function the time difference is calculated by firing the function with the users start and end time of the shift. (Every row the php gave as a response is a finished shift)

```js
// function to calculate the difference between the two times
const getTimeDifference = (time1, time2) => {
  let startTime = new Date(`${time1}`);
  let endTime = new Date(`${time2}`);
  // Calculate the difference in milliseconds
  let timeDifference = endTime - startTime;
  let timeDifferenceInHours = timeDifference / (1000 * 60 * 60);
  return timeDifferenceInHours;
};
```

Here I fire the function above and make it sum up with the data thats already in the variable. The if statement is to have only the shifts that started not earlier then last week. I have to do this because the response from php were all the shifts from last month.

```js
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
```

Here I push all the data from the user object into some array's which are given to the chart.js function.

```js
usersArray.forEach((user) => {
  namesArray.push(user.name);
  workedHoursArrayMonth.push(user.workedHoursMonth);
  workedHoursArrayWeek.push(user.workedHoursWeek);
  lunchMinutesArrayMonth.push(user.lunchMinutesMonth);
});

makeChart(workedHoursArrayMonth, namesArray, labelHours, workMonthSection);
makeChart(workedHoursArrayWeek, namesArray, labelHours, workWeekSection);
makeChart(lunchMinutesArrayMonth, namesArray, labelMinutes, lunchMonthSection);
```

### Result

Here is an image of the graphs on the page:

<img src="../assets/graphsPage.png" alt="img" width="1100" height="auto">

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/blob/main/web/static/js/charts.js?ref_type=heads">Link to the chart.js file</a>

### Conclusion:

Users get now so much more insights in the data that is gathered when every one is checking in and out.
The bos can see how many hours everyone made and how many breaks too. For the Employees I implemented a graph that covers only the hours of the week so its easier to see if you made enough hours this week. What I learned about this research is that you can do a lot with certain data that is gathered, if I had more time I would have add more graphs or statistics like the average time a person or a whole group of employees start and end with their work, the average break time, on how much percent every one is with their hours and the agreed hours per week and many more. I also learned a new library and using it in a way that allows it to use like a dynamic function. I will definitely use this library again in other projects when needed an discover more functionalities it has to offer.
