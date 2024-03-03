# Technical Documentation

<!--
Your technical documentation should contain information about the design decisions you made, the problems you encountered and how you solved them. It should also contain information about the technologies you used and why you used them. It should also contain information about the structure of your website, and how the different parts of your website interact with each other.

In your technical documentation you should also describe how you tested your application, and how you deployed your application. -->

## Design decisions

- I split my whole php code in to multiple files because I want to have an organised workspace and dont run code when its not necessary. These 10 files are explained in <a href="../api_reference">api_reference</a>. Some files have multiple functions like deleting and adding things to the database but the file is only accesable in one way. I chose for this because it becomes still clear to understand but its still splitted in files that have contact with different database tables.

- I also have chosen to use scss for the styling of my website and run a taskrunner like gulp to convert it to css. I did this because I have found scss easier to use and write and you can use gulp for multiple purposes like minify and uglify files like css and js to load it faster for example. This could be nice in the future.

- I am using AJAX from jQuery to load sections with dynamic content instead of reloading the whole page. After some research I understanded how it worked and I found it very easy to use and change things if needed.

## Problems

I encountered some problems while working on my project. And this was mainly because I never heard of the things I had to work with like php and AJAX.
With some trial and error I managed to let it work but after some feedback and looking in the rubric on DLO again I saw that I did it in the wrong way. I thought there where no html files and only php files with html in it. And I didn't now how to load the php data in the html before I knew that it had be done via AJAX with Javascript.

## Test

I often tested my project when I was working on it. When I wrote something I would start up my project, scan the card and watch the website and database if everything went as aspected. Sometimes it didn't go as aspected and most of the time I echo'd an error in the Serial monitor or on the webpage itself. If I didn't got an error, I tried to figure out where it went wrong by following the route of the data and echoing along the way. When I found it I echo'd the error or saw that I made a stupid mistake which I had overlooked.

## Deployment

In order to run my project on your own device you need to follow these instructions:

1. Download the zip of the project from <a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20">this gitlab repo</a>, and open the zip.

2. Create an .env and paste these lines in it and change them to your username and password, and maybe other ports if you already using these:

```
HVA_USERNAME= yourUsername
WEBSERVER_PORT=80
MYSQL_PORT=9000
MYSQL_ROOT_PASSWORD= aPassword
```

3. Install docker and run this command in the terminal in the same layer as docker-compose.yml

```
docker compose up
```

This will create all docker containers and let them run so you have access to php, the database, and be able to send requests and responds to and from your embedded device.

4. go to http://localhost/dashboard/ and http://localhost and look if you have access to your database, tunnel and website

5. In the .ino file you have to change these to your own network:

```
const char* ssid = "wifiNetwork";
const char* password = "password";
```

And this http link to your own api

```
httpClient.begin(wifiClient, "http://yourOwnTunnelURL/api.php");
```

You can get "yourOwnTunnelURL" when you click on HTTP tunnel on the http://localhost/dashboard/ page and copy the url of the page.

6. Run the checkInOut.ino on the embedded device.

The .ino file will make a network named: checkInOut, you will need to connect with another device to that network and go to this IP adress in your browser: 192.168.4.1
Now you need to fill in the network and password which you want to connect.

7. If you want to make design changes you need to install npm if you haven't already and run this command in the terminal:

```
npm install
```

and

```
gulp watch
```

This will install gulp and all the other libraries and let them run and watch if you make changes to any of the scss files.
