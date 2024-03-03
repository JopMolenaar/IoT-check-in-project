# Design

I am going to make a time registration machine where employee's can check in at a little box. That little box could be inside and outside, it totally depends on how you want to use it as a company. In my case it will be inside and will look like a small box with 2 LED's, a small screen and 2 buttons. This product wil be used to register the times that employees work, how long they work and when they worked. But it could also be handy if you want to know how many people are in the office, what department they are from and for the boss maybe an table with all the hours the employees have worked this month. You could also expand this prototype to for example giving acces to locked doors.

## About the user

The user of this product is someone who wants to check in to register his time. In my case I am focussing on a web developing company that has a few employees. The user is the employee and when he/she wants to start working he/she needs to check in to register his start time. If the employee is done for the day, he/she needs to check out at the same machine for completing his shift. This information is displayed on the web app that all the employees can see and is a handy tool for the boss to see if everyone was in the office and made their hours.

The users want to have an easy check in and out and not an task that requires some time. So this machine could be matched with for example unlocking a door because that is a task that you already have to do. It also needs to be accurate and provide good and enough feedback to the user when they scan their own card.

The requirements need to be SMART. SMART stands for Specific, Measurable, Attainable, Realistic, Timely. I also wanted to add MoSCoW because these show what requirements have a higher priority then others.
These are the requirements in a list:

## Embedded requirements

### Must have:

- The machine must provide feedback to the user by displaying his/her name.
- The machine must let the user know if he/she checked in or out by displaying "Welcome" or "Have a good day".
- The machine must provide feedback to the user by letting the status of the check in/out know by using green and red LED's.
- The machine must respond with text on the screen and a burning led in 10 seconds.
- The machine must respond with the right data like name and a burning green led when your acces is granted.
- The reader inside the machine must always be able to read the card id when you touch the place with the card where you check in.

### Should have:

- The user should be able to check in using only one hand.
- The machine should respond with text on the screen and a burning led in 5 seconds.
- The machine should be splash-proof because of all the electronica inside. -> testing this with paper inside and throwing water on the machine box.
- The case should be able to open if you want to replace parts for example.
- The machine should be able to hang to the wall at belly height.
- The machine should have a small incline so its easy for the user to read the screen when the machine is hang below eye sight.

### Could have:

- The machine could be linked with anohter task that the user needs to do anyway.
- The machine could be waterproof because of all the electronica inside. -> testing this with paper inside and throwing water on the machine box.

## How I am going to make it

I am going to make it with a 3D printer because it is cheap, strong and can be waterproof if you want that, I will design a small box with fusion 360 wich I have used before. Firstly I will make a paper prototype to make sure I made the right measurements. After that I will print small things to check again if the measurments I took are good and fit around my circuit. After that I will print the whole thing.

I am going to use **PLA** because it is kind of waterproof, strong, cheap (0,05 euro per gram) and biodegradable. I have chosen for PLA instead of ABS because PLA is safer in case of toxic fumes and that is something I find very important, but both require a good ventilation. This can be printed with the **Ultimaker 2+** at the makerslab at the TTH building.

## Design sketch

I made a design for the machine:

<img src="../../assets/sketchDesign.png" alt="Here will come an img of the final sketch" width="500" height="auto">

It is basically 2 boxes above eachother where the upper box has magnet strips in the inside, and the box under has magnets outside. By placing the boxes on top of eachother the magnets will touch eachother but you can easily open the box and it is not likely that water will go in the inside so it is kind of water proof. The upper box has a small incline like I said.

I did not really know what the dimensions of the machine would be so I made a paper prototype to see how big everything needed to be. I measured the components and started folding paper.

<img src="../../assets/paperPrototype.jpg" alt="" width="400" height="auto">
<img src="../../assets/inclinePaper1.jpg" alt="" width="400" height="auto">

### Dimensions

The dimension that came out of it:

- LED's = round hole with a diameter of 5mm.
- Oled display = rectangle 34mm by 18mm
- Button = round hole with a diameter of 5.3mm and square of 12.2mm by 12.2mm with a thickness of 1mm so the button can be pressed.
- The width and length was 105mm which seemed big enough for the WeMos to fit in.

## Digital design

I have chosen fusion 360 to make my digital design because I have used that before and it is easy to make a design with accurate dimensions.

- I first made a sketch in fusion 360
- After that I extruded the box
- But I wanted to print without supports if needed so I had to rotate the upper part

<img src="../../assets/collageDesign.png" alt="digital design sketches" width="900" height="auto">

To test if my measurments are correct I will make another file where I have parts of my print that I can test before I print my final design.
This is a picture of that file and I printed the case at Miquel:

<img src="../../assets/collagePrint.png" alt=" digital design sketch for testing" width="900" height="auto" >

After this I came to the conclusion that 5mm walls are too thick and that I forgot to make a hole for the usb cable. I also tested if all the measurments I took fit, and that was not the case. The led holes needed to be 0.3 mm bigger because they fit in the button hole but not the led holes. The print at Miguel did not went well because I did not rotate my design the correct way so there was space underneath the design and the print board. So I fixed these changes in my digital design:

<img src="../../assets/fixDesign.png" alt="3D desing with changes" width="900" height="auto">

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/tree/main/designFiles/frontSideDesignFiles?ref_type=heads">Click here for the .step and .gcode file (Front side)</a>

In the timeline you can see the different versions.

After I printed the front side I also made a test print for the backside at
Miguel. The backside was a little disappointing and gave me the insight that my idea was a little difficult so I had to change the design.

<img src="../../assets/secondBackSideDesign.png" alt="" width="500" height="auto">

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/tree/main/designFiles/backSideDesignFiles?ref_type=heads">Click here for the .step and .gcode file</a>

I made the outer walls go at the outside of the frontside and the idea is that a magnet I had need to touch with the other magnet that are both stuck on each side. I also made a little extra room for the embedded circuit.
