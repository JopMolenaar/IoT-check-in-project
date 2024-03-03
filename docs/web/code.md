# Web Code

<!-- Your code should follow the conventions of the language you are using. It should also be well documented. On your portfolio you describe how your code works and how it is structured. Make sure you link to your code on your repository. -->

## Code

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/tree/main/web">Link to the code</a>

I have two javascript files where I load the sections with dynamic content with AJAX (from jQuery). I included this line of code in the head of the html to use jquery:

```html
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"
></script>
```

I am loading a file from the PHP API and get a respond with data.
In tableCheckIn.js I calculate the time between the start time and the current time. This function is repeated every 3 seconds.

Make data ready for the function:

```js
// change the text inside the "How long checked in?"
const parts = row.startTime.split(/\s+/); // split things I don't need in starttime
let timeStart = parts[1].slice(0, -3); // make starttime ready for insert in setHours function
let timeEnd = row.curTime;
let dateStart = parts[0].replaceAll("-", "/");
var currentTime = new Date();
var year = currentTime.getFullYear();
dateStart = dateStart.replace(`${year}/`, ""); // delete year
let checkInTime;
```

Calculate the time difference:

```js
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
```

Calcuate the hours and minutes:

```js
// Converting milliseconds to hours and minutes
const hours = Math.floor(timeDiffMillisec / milliSecondsInHour);
const minutes = Math.floor(
  (timeDiffMillisec % milliSecondsInHour) / milliSecondsInMinute
);
```
