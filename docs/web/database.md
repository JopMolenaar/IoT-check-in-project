# Database

**Your database should be well documented. On your portfolio you describe how your database is designed and how it works. You include a diagram of your database made in MySQL Workbench.**

I used mongoDB with nodeJS before but in this project we have to use php and MySQL. This is totally new for me but I'm inquisitive and eager to learn it.

I watched some tutorials on php and MySQL to give me an image on how it works.
SQL basics:

- <a href="https://www.youtube.com/watch?v=Cz3WcZLRaWc">https://www.youtube.com/watch?v=Cz3WcZLRaWc</a>

HTML form with php connection to MySQL database:

- <a href="https://www.youtube.com/watch?v=nP-MvFoDVZE">https://www.youtube.com/watch?v=nP-MvFoDVZE</a>

I understood it a bit better but what I needed to do was setting up a connection myself, and I did.

## Database diagram before my feedback

This was my database diagram with the structure:

<img src="../../assets/db-diagram-two.png" alt="img" width="500" height="auto">

### Short explanation

If someone checkes in, the API will look in the table **"Users"**. If the user exists it will be stored in the table **"checkedIn"**. If the user checkes out, the user will be deleted from this table and inserted in the table **"History"**.

## Database diagram after my feedback

I learned a lot from the feedback I got from Dorus and Mats, they said things about inner join, that I could delete a table and make it more efficient and what those lines were between my tables. I fixed all these things in my database and this was my structure after that:

<img src="../../assets/databaseDiagram.png" alt="img" width="500" height="auto">

I have chosen to make a time registration product for a company so it can track the shift times of the employees. I have employees that are the users of this product and these users need to go in a database. The first database table is **"User"**. I need to store the **id** (because every user is unique), the **name** and the **card id** of the user. Thats because if he/she checkes in with a unique pass, it has a unique card id that is linked with the employee.

If <u>someone scans their card</u>, php will look if that person has an endTime that is null in the table **"checkInOut"**. If not: it will add that user with a startTime. If yes: php will give the user an endTime. If you checked out but you have a break start time and no break end time, it will fill in your end break time and give you an endTime.

If <u>someone scans their card with the button pressed at the same time</u>, php will look if that person has an endTime that is null in the table **"checkInOut"**. If yes: php will respond that you first have to check in. If not: php will look if you already have a break start time. If that is true it wil give you a break end time. If that is false it will give you a break start time.

More about how the code works with all the if and else's? <a href="../code">Go to the code page</a>

Here is the <a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/blob/main/build.sql?ref_type=heads">sql build file for this database</a>
