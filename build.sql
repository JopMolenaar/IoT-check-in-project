/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 08-11-2023
Description: This is the build file to build the database where the php scripts are based on. 
*/


  CREATE TABLE [timeRegistration].[User]( -- you could change timeRegistration if you want these tables in another group, make sure you also change that in connect.php if you do
    [id] [int](11) IDENTITY(1,1) PRIMARY KEY, -- id is for every row in this table unique
    [name] [varchar](50) ,
    [card_id] [varchar](50)
  );


  CREATE TABLE [timeRegistration].[CheckInOut]( -- you could change timeRegistration if you want these tables in another group, make sure you also change that in connect.php if you do
    [id] [int](11) IDENTITY(1,1) PRIMARY KEY, -- id is for every row in this table unique
    [userId] [int](11) ,
    [startTime] [datetime],
    [endTime] [datetime] NULL, -- these NULL columns will be overwritten in php when there is data for it
    [breakStart] [time] NULL,
    [breakEnd] [time] NULL,
  );

