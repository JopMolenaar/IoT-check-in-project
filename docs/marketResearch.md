# Market research

For the market research we have to expand our project by adding a feature. We do this after we finished all of our tasks and submitted them on DLO. We have to do research about what we want to add and why.

## Idea's

In the time I build my project I already got some ideas about what I would want to add.

1. Expand my embedded device with a task that fits really well with checking in/out.
   Think about this: you have two tasks and both require input from a user. Combining these tasks to one required input will help the user completing these tasks with less energy and time. A task that fits good with checking in/out is for example opening a door. That is because mostly the check in/out station is located at a place where you already need to be, mostly a door. In my case the user can be declined from the check in/out because we dont want people in the database and on the website who aren't meant to be there. This concept could also be combined with a door that will give you acces to go through or not. And how cool would it be to have a automaticly opened door if you checked in or out.

2. Expand the data handling of my site.
   When you check in or out, go on a break or come back from a break, it all goes to the database. Right now I have two tables, one with who is checked in, and one with the history of who are the last ten people that have checked in (with the start, endtime of the shift and break time). When I look at my site I am not really satisfied with all the content I have. And with all this data I collect, I can do so much more. Think about tables with how many hours everyone worked this month and this week, average start and end times of the employees, how productive everyone was with their commits or lines per hour for example.

When looking at these two we can jump to the conclusion that we have two totally different ideas. An embedded idea and a web app idea and I have for both a valid reason to implement them in my project. I am currently studying CMD on the HvA and that is more about webapplications. I have more knowledge about that so it would be a challenge and interesting to do something different and focus more on the embedded part. But I have more interest and want to become better and gain more skills on the webapplications part so choosing for option two would also be a logic choice. I will not fall in repeat if I do point two, and this will also be a challenge because this focusses more on data handling with backend and making graphs with frontend which I never did before.

## Research questions

- How can I find a way to use this data that I am gathering for multiple other purposes to help the user understand the data better?

**sub-questions**

- For which purposes could this data be relevant?
- What is a good way to bring the data to the user?
- What kind of library or framework can I use for this?

### For which purposes could this data be relevant?

The data I am gathering now exists out of a lot of shifts with times. You can see which user started a shift, when it started, when it ended and when the user had a break with the start time and end time.

On my website now, the data is used to fill three tables and these show which user started a shift, users that have done shifts in the past, and on another page I show all the users that have acces to use the system, this is more of a admin page on the website.

When you want to put this product on the market you should expand the data handling so it can be used for multiple reasons and that means a bigger audience and more sales. But what do you want to see when you are a employee or a boss? An answer to that is the hours you made, that is because for the boss its easy to check if you worked enough and for the employee its almost the same reason. Salary is mostly paid every month so you need a way that will tell you how much everyone worked this month in hours. I am going to make another section with information that does the same but then instead of per month, per week. This is more for the employee to check if they worked enough because they look more often how many hours they made per week then per month, for example you say that you work 40 hours per week instead of 160 hours per month.
I will do the exact same thing for the break hours everyone took per month. This is because it gives a clear image of how much an employee has been in the workspace.

### What is a good way to bring the data to the user?

There are many ways to present data to users, you can do it via just straight up showing numbers or diagrams, graphs, pictures and more. I found personally that a very good way for people to receive information is receiving it via graphs. That is because you can see connections between employees and have a clear view of the data very fast. But there are multiple sort of graphs. You can show Bar charts, line charts, pie charts, column charts, scatter plots and so many more <a href="https://piktochart.com/blog/types-of-graphs/">(piktochart.com, "20 Essential Types of Graphs and When to Use Them")</a>. I am going to use the bar chart because I want to show how much an employee worked over a period. I also want that you can see some connection between the employees, and that is possible with a bar chart. That is because you can easily see if someone has worked less then someone else.

### What kind of library or framework can I use for this?

Making this data visualisation with vanilla Javascript will be a pain in the ass and very challenging so I looked around if I could use a library for that. I searched for data visualisation libraries Javascript and found a very big list with al sorts of these libraries. Some of these where: D3.js, Recharts, Victory, ApexCharts. I looked for a populair library that was not to big or difficult to undertand. I ended on <a href="https://www.chartjs.org/docs/latest/">chart.js</a>, it has 56k stars on github, has only six different charts and is beginner friendly. I never used this library before so I did some research on how to install and use it and that was pretty easy to understand.

### How can I find a way to use this data that I am gathering for multiple other purposes to help the user understand the data better?s

By answering the past questions I can answer this question. I can use this data that I am gathering for purposes like giving more insights about how many hours the employees ahve been working per month and per week. This is interesting for the boss and the employees. That is because the boss wants to see how many hours the employees are actually working and the employees can check if they are working enough. A great way to show this data to the users is by using bar charts. This way the user can quickly see some relations between the employees, it is uses numbers instead of percentages, and creates a great overview for the boss. A way to make this with Javascript is by using a library like chart.js. It is popular, has a lot of documentation, is super easy to use and does the job.
