# Create

## Manual manufacturing

Before I created my digital design I ofcourse had to test the design with a paper prototype. What I wanted to test is:

- If the hole dimensions fit the embedded parts.
- If it is enough room for the embedded circuit.

How I am going to test this is by making a paper prototype using scissors, paper and a pencil.
While doing this I was using a ruler to measure the dimensions of the LED's OlEDS and the walls of the box. This is the prototype that I made:

<img src="../../assets/paperPrototype.jpg" alt="" width="400" height="auto">
<img src="../../assets/inclinePaper1.jpg" alt="" width="400" height="auto">

I had to do it over a couple of times before I got the right demensions and have it how I wanted it.
I wrote the dimensions down which came out of the paper protype. And I thought the embedded part would fit in the protoype. But paper is not so strong and I couldn't really hold it together so I made the assumption on my visual information that it would fit. I liked the incline of the box and was positive that my idea was going to work with the magnets.

## Digital manufacturing

After that I made a digital test design based on the paper prototype. I wanted to see if the embedded parts really fit the holes because 3D printers have things like wall thickness and layer thickness which could have effect on your dimensions. I first tested the front side of the design because that has the most holes to test of the two. I printed this test print at Miguel on the Ender-3 pro with a 4mm nozzle and PLA as the material.
This was the test print:

<img src="../../assets/frontviewTestPrint.png" alt="" width="400" height="auto">

I had to change the dimensions of the LED holes because these were not big enough.

On Thursday 12 Oct I made my first 3D print of the front side of my design in the makerslab. I printed with the ultimaker 2+ connect, 4mm nozzle and PLA as the material and it was already calibrated.
I set the resolution to normal because I wanted it to be specific but not be a 20 hour print.

<img src="../../assets/printingFront.jpg" alt="" width="400" height="auto">

On Friday 13 Oct I looked how it worked out and I was pretty satisfied.

<img src="../../assets/frontSide.jpg" alt="" width="400" height="auto">

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/tree/main/designFiles/frontSideDesignFiles?ref_type=heads">Click here for the .step and .gcode file</a>

That day I soldered the LED's and the button to the wires and also made a test print for the backside at
Miguel with an Ender-3 pro with a 4mm nozzle and PLA as the material. The backside was a little disappointing and gave me the insight that my idea was a little difficult so I had to change the design.

<img src="../../assets/backSideTest.jpg" width="400" height="auto">

I could print my second design at the end of the day at the makerslab. I printed with the ultimaker 2+ connect, 4mm nozzle and PLA as the material and it was already calibrated. I set the resolution to normal because I wanted it to be specific but not be a 20 hour print.
The first layer wasn't the best but after staring 30 minutes at my print I was guessing that it would be alright.

<img src="../../assets/printingBackSide.jpg" width="400" height="auto">

That monday I went to school to get it and it was well printed.

<img src="../../assets/backSideFinal.jpg" width="400" height="auto">

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/tree/main/designFiles/backSideDesignFiles?ref_type=heads">Click here for the .step and .gcode file</a>

The back side fitted perfectly on the frontside and gave enough room for the embedded circuit. This is how it looked when I put all the parts in:

<img src="../../assets/allThePartsIn.jpg" width="400" height="auto">

The last few things I had to do was buying magnets and place them with glue on each side. Place some glue under the button so it would click form the outside, and place some tape on the oled display so it would stick in the hole.

## Final product

The final product looked like this:

<img src="../../assets/collageOfProduct.png" width="900" height="auto">

This is how its used:

<img src="../../assets/checkInFlow.png" width="900" height="auto">

Other stages:

<img src="../../assets/otherStagesFlow.png" width="900" height="auto">

These pictures here above were form before adding the magnets and fixing the button. I also made the design even better by adding some labels. This is the inside and frontside now after adding some labels and magnets and fixing the button:

<img src="../../assets/lastPictures.png" width="900" height="auto">

### About the requirements

#### The requirements I reached are:

- The machine must provide feedback to the user by displaying his/her name.
- The machine must let the user know if he/she checked in or out by displaying "Welcome" or "Have a good day".
- The machine must provide feedback to the user by letting the status of the check in/out know by using green and red LED's.
- The machine must respond with the right data like name and a burning green led when your acces is granted.
- The reader inside the machine must always be able to read the card id when you touch the place with the card where you check in.

- The user should be able to check in using only one hand.
- The machine should respond with text on the screen and a burning led in 5 seconds.
- The case should be able to open if you want to replace parts for example.
- The machine should have a small incline so its easy for the user to read the screen when the machine is hang below eye sight.

#### The requirements I reached did not reach are:

- The user should be able to check in using only one hand. -> The reason this requirement is here also is because in most cases you need two hands to check in and out for a break. That is because you need to press a button and scan your card.
- The machine should be splash-proof because of all the electronica inside. -> I did not test this requirement because I don't want to ruin my embedded circuit and it was already inside when I wanted to test it.
- The machine should be able to hang to the wall at belly height. You could theoretically hang it on the wall if you screw the backside on the wall but I did not buy anything to add on my design to make it instantly hanf on the wall.
- The machine could be linked with anohter task that the user needs to do anyway. -> Chose for something else for my research phase.
- The machine could be waterproof because of all the electronica inside. I did not test this requirement because I don't want to ruin my embedded circuit and it was already inside when I wanted to test it.

### Future improvements

In the future I could make it splash proof by adding some plastic on the outside of the OLED display and adding a layer of foam or something that wil close the crack between the front side and back side.

I would iterate further on the casing then I did now to improve it and make it as good as it can be.
One thing that would be the first to change about this design is the way the button is integrated. I don't have high hopes on the lifetime the button will work, and there is a far better way to do it. (I explained this in failures.)
