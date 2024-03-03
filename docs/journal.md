# Learning journal

Your learning journal can be seen as a diary of your learning process. It is a place where you can reflect on your learning, and where you can keep track of your progress. It is also a place where you can keep track of your questions, and where you can write down your answers to those questions.

So for example when you receive feedback on your project, you can write down the feedback and your reflection on it in your learning journal. You can also write down what you have learned from the feedback, and how you will apply it in your project.

## Week 1

This week I learned a lot of php, I never had any experience with php but I have with nodeJS. So I watched a couple of video's and tried to make it work. I struggled a little bit but after a while I had a connection and the rest was easy.
I set up a connection with the database with php and managed with some help to insert data and get data to to my website.
I was struggling with how I could send the data to my html page but I found out php can be a html page with backend components.

I also started this week trying something with the embedded part and learned how to breadbord works and that it is safe for my product to plug out the power when im plugging things in my breadbord. This could cause short circuit what could kill your components. I also learned how the wemos and the circuit worked with resistors and ground wich I did not know before.

## Week 2

This week I focussed more on the embedded side of the project.
I had a little trouble with the button on my board but with some help we managed to fix the problem. The problem was that it was not connected to a digital pin. I asked how that was different from the rest of the pins and that had to do with a inside resistor.

This week I also asked feedback on my planning.

### Peer feedback I got from: Ralph Andrich on Planning

#### Tips:

In the beginning, it's hard to plan in detail. I do think this planning might be too global. Things u could improve: - Create a task list and plan the individual tasks / subtasks. - add an ending date to the table. - create soft deadlines / prototype deadlines - Spend time on each of the vertical slices each week.

#### What I changed

I was happy with the feedback I got, I already expected this kind of feedback but it was a nice extra indicator that I had to chnage something. This day I went trough all the rubrics and requirements and was a little overwhelmed. But because I did this I could place some keywords in my planning every week where I could focus on.

### Coaching Mats

This week I had my first coachingstalk with Mats. Everything was as expected and I asked some questions. One was about an IP problem wich he could solve by restarting docker and the other one was about why I could not echo the variables on my php page wich I got from my wemos. This was because it should first need to be send to the database from the php file and after that you can acces the data from the backend to the front-end. If you echo the variables to the frontend immediately it wil be send back to the API and it wil show in the serial monitor. I found this a bit confusing but it is what it is, and the good thing is that I know how it works now and THAT it works.

### A friday where my embedded components said no...

I received my ordered compentents on thursday and wanted to implement those in my circuit. Firstly the OLED display. I watched a tutorial how I needed to connect it and make it work. I had code that should display an Adafruit logo and an animation after that. But it did'nt show nothing. After trying some debugging things I asked for help to a student assistent. We tried some other things but nothing seemed to work. One thing that was remakable was that it did not show any text in the serial monitor, but we could'nt fix it. I had enough and tried to make the RFID KIT MFRC522 S50 Mifare work. After some soldering, connecting the wires with some help, and following a tutorial on how I should use the component, I tried to run the dumbinfo example of the arduino app. And again, it did not work. I even checked if I had soldered correctly by testing the component on someone elses circuit, and it worked. But in my circuit it did not. And again, I did not saw anything on the serial monitor. I asked for help to 2 student assistents, 2 students, and a teacher. We tried to change the wires, running other code, ask chat GPT, but nothing solved my problem.

So my plan was to let it rest and ask again on wednesday to Gerald.

## Week 3

This week the goal was to finish the whole cicruit communicating with the web app.

The wiring diagram was a very difficult part for me, that was because I did not really knew where to connect the components because it was mulitple times not working. I got help from many people and searched a lot on the internet but the information was different every time. This first try to get a good diagram was based on the four sources:
https://randomnerdtutorials.com/esp8266-pinout-reference-gpios/
https://github.com/miguelbalboa/rfid#pin-layout
https://www.youtube.com/watch?v=KQiVLEhzzV0
https://www.viralsciencecreativity.com/post/arduino-rfid-sensor-mfrc522-tutorial

<img src="../assets/first-fritzing-circuit.png" alt="img" width="500" height="auto">

Wednesday I got a little feedback point on my fritzing diagram form another student. He said that the Wemos should be on the breadbord, so I changed that.
After some rewiring was this my diagram.

<img src="../assets/second-fritzing-circuit.png" alt="img" width="500" height="auto">

### Wednesday

Today I wanted to make the components on my circuit work, and fix what I started friday. Again, I saw the questionmarks. After some trial and error, googling and asking my co students it still did not work. I asked the teacher that was there and he said something about setClockDivider and something about speed to communicate with the RFID reader. So I looked up the datasheet of the reader, and saw that the frequenty was 125/134 KHz. So I set the setClockDivider to DIV128 in the arduino code and tried again. Did not work. I switched Wemoses with co students, and looked more on google and wanted to ask the teacher again but he wasnt't there anymore. On this point I almost wanted to give up and use a button instead of a RFID reader. But then I saw a student who got it working on her WeMos. I looked at her code and saw some lines that I was missing so I asked her the code and tried it myself. And that worked.
Some lines that I was missing were:
This:

```c++
  dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
```

And these:

```c++
void dump_byte_array(byte *buffer, byte bufferSize) {
for (byte i = 0; i < bufferSize; i++) {
  Serial.print(buffer[i] < 0x10 ? " 0" : " ");
  Serial.print(buffer[i], HEX);
}
}
```

### Thursday

Thursday I asked feedback about my fritzing diagram and database design. For the fritzing diagram I had to change one connection for the button.
And for the database...
This day I also got a kind of feedback that I should load my data via AJAX and php to my html instead of directly in my php file. I did a bit of research about AJAX, and tried to make it work in my website. I struggled a lot with this because I did not even know how it worked but I had a clear idea how I wanted it to work. I wanted it to refresh a certain section when another php file was inserting the data to the database but I couldn't get a connection between those two. All the youtube video's I watched did it with an button but I wanted it to be automatic so I used setIterval in Javascript. This method worked and I expanded the function a bit more so the history table reloads when you check out, and that looked really cool and I was very proud of myself

### Friday

Friday I did a lot for the data that is added and deleted from the databases with php. That data is send from the WeMos to the api, I managed to send back some information with php to the WeMos for example if the data is found or not found. I have made some if else statements for those conditions in c++ and next week I will expand the circuit based on that.

I had no performance meeting with mats this week because he was sick. And I did not write a whole lot of words in my portfolio this week because I was so busy to get my embedded part working with all the extra php code. I had never worked with php and the WeMos before so that was a challenge but I managed to do a lot with the help of googling and a bit of peer-students.

## Week 4

On monday I had a coachingsmeeting with Mats about last week, I showed him what I made and he was impressed. I also showed him how my databse worked and he said that it could be done differently. He talked about some things, he assumed I was a hbo-ict student but I did not understand it really well. After he found out I was not a hbo-ict student he was even more impressed about what I had made so far. He then explaned the database option that I could use in a language that I could understand better and talked about inner-join. That was because I stored variables in tables that were unnecessary and could easily be fixed with inner-join. He also said that I could delete the table checkIn and look in history of that person has already an endtime or not. That way you can use one table for multiple purposes.

This week on wednesday I managed to fix the OLED screen and let it work in my circuit.
But I also came across a problem about my pins. That was because I had now 2 output sensors and 1 input sensor and that had to be 2 output sensors. I was planning on adding one or two buttons but but I had no more pins left. I looked up some solutions for this problem like a backpack, shield or arduino and maybe sharing pins with other sensors but I couldn't decide what I should do so I asked a teacher. But he said I could use TX and RX as normal pins and add a button on one of those pins. So I tried that but I had a hard time to let it work. I tried it with interrupts but that also didn't seem to work.
I found a video that said that inputs on those pins cause trouble with the serial monitor so I decided to switch the button with one of the LED's. The button was now on pin 16 but that also did not work entirely correctly, ones you pressed the button it did not unpress it so I asked Mats and he came up with a solution involving a resistor, and that worked.

This week I finished: BOM, Design, the php data flow and the embedded part of my project. I also rewired my wiring diagram and double checked it with the requirements on dlo. This became my final diagram:

<img src="../assets/finalDiagram.png" alt="img" width="800" height="auto">

## Week 5

This week I asked a lot of feedback and this wednesday I learned something new about how you should explain the c++ code, even though it was not in the rubric, a student said to me that you have to explain the parameters in a function by using @nameOfTheParameter and give it a discription.

- I also asked this week how I could find the manufacturer and id of the parts in my BOM
- Started this week with optimising my php code
- Started with system architecture
- started with design and got design feedback.

Had a performance review this week with Mats and asked a couple of things about AJAX and he said that I was using it the correct way. What I could improve in my php code was the use of json. Im sending json to my embedded device but not in the correct way.

## Week 6

This week I focussed more on design. I made a paper design, digital design and started to print test prints on wednesday. I also finished my system architecture.
I also had a coachings meeting with Mats and he said that I should ask feedback to Gerald and that I could use my little breadbord for my embedded circuit.
It went from this to this:

<img src="../assets/bigToSmall.png" alt="img" width="800" height="auto">

## Week 7

This week was mainly about documentation and asking feedback for the last things. I struggled a bit with how I wanted to finish my design. I had magnets in mind to let the front side and back side stick together, but of course I was getting other idea's which left me hesitating which one to do. Finally I decided to stick with my original idea.

## Week 8

This week we had a autumn recess. I did not do that much but I answered some of Wilko's questions and made some changes to the frontend etc so I could have a flying start the last week of this project.

## Week 9

This week was the last week of the project. I had still no answer of the four people where I wanted feedback from so that was a little frustrating. Also the clock went back one hour and that caused a problem in my code. The summer time was visible instead of the winter time so I had to change this. I changed this by getting the Amsterdam time zone and change the format of it. This made the code more flexible and accurate.

What I needed to do that week was getting feedback, finishing the last embedded requirement that got explained last minute, finish research phase and glue some things on my physical design and make some pictures of it.

On monday I almost finished the research phase.
On wednesday I tried to make the embedded requirement work but I did not succeed. I had a weird error when starting the server on the WeMos. I let it rest and asked on thursday how I could fix it.
I also glued the last few parts on my physical design but accidentally glued my button which made it unable to click. I had to fix this problem on the thursday by soldering another button on the wires and use tape to make it stick on the design. I also came across some things that I had changed without changing for example the system architecture. So I had to do that also.

On thursday there was a huge storm so I couldn't get to school, this was a little problem because I had a question regarding embedded requirement two. I managed to solve it in more then 4 hours and I did it in a way that wasn't the best solution. I could not get the ESP8266WebServer.h library to work. I got an really weird error with the --EXCEPTION DECODER-- and I was trying a really long time to solve it. At the end I followed the link that Gerald had send on DLO. I followed it step by step and it worked with using the ESP8266WiFi.h library. The only problem now was that I had do delete that library earlier because we had to use the Wifi manager according to the rubric. I did not know what to do so I am the connection the wifi with two different libraries because I could not let two requirements work in one file.

On friday I gave a lot of feedback to everyone and fixed my physical design by glueing parts and making labels where needed. I also had to replace the glued button by soldering it off and soldering an other button on the original wires. After that I found a solution to make the button click by placing a dice behind it. When placing the magnets in the design I made a huge mistake by testing the magnets and let it rest in the closed state. When I wanted to make pictures of the inside I could not open the box. After some knife stabs and really hard pulling I managed to get it open.

## Week 10

This week I did the last few things and got the last feedback points back. One of them was the system architecture with really good tips like The gitlab repository does not store the whole project in your diagram, mentioning versions of php, nginx etc, some things about writing down ports for maybe setting up a firewall in the future, questions like What IDE are you using? And a tip that LED's use a GPIO protocol. I also got a bit of feedback about my research and after I added all those tips I checked everything before I uploaded it on DLO.
