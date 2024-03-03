# System Architecture

## Introduction

A system architecture is a overview of your project. The purpose of having a system architecture diagram is that other people can see what you made and how it works. If they want to recreate or change a thing on your project they can use this diagram. It also has a purpose of documentation. If you want to show your project to others or if you for instance needed to make this project for a company, they want to see what you made and how it works.

## System Architecture Diagram

<img src="../assets/system-architecture.jpg" alt="img" width="1100" height="auto">

### Little explaination

In the top you see the embedded device (red) containing three output sensors, two input sensors and four libaries used. The WeMos is connected with the iotroam router and the hardware device that I use is connected to the Edurodam router. Both the routers are connected with the Edurodam internet. The hardware device that I use (MacBook Pro with Ventura 13.3) contains docker that is hosting multiple things like: nginx (webhost), php, a HTTP tunnel (for connection between embedded device and the web application), MariaDB (which hosts the database) and phpMyAdmin (GUI for database). The WeMos in the middle of the embedded device sends a HTTP signal through the HTTP tunnel, to the API (orange)(backend of the web application). The data send to the API will be inserted in the database. On the left side you have the webapplication with all the HTML, JS, SASS and CSS files coded with Visual Studio Code. SASS uses Gulp as a taskrunner to convert SASS to css. All those files are stored in the gitlab repo, and also create the whole web interface which is hosted by nginx. If you acces the web interface with one of the hardware devices by using a browser, Javascript will use AJAX (jQuery library) to run a specific php file which will give you a response with data, and Javascript will place it on the web page so you can see the data.
