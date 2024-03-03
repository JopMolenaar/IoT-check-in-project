# Design/ print failures

## Failure one

My first design I made looked like this:
This was before I did anything with the embedded part of the project so I did not know what I wanted to use exactly.

<img src="../../assets/blueprint-iot.png" alt="An image of a box with buttons, a screen and a place on the top where you can scan your card" width="300" height="auto">

This won't happen the next time because this was a result of knowing nothing about embedded. When I knew something more about embedded I made a second design.

## Failure two

This was my second design for the check in tool:
It is like a OV-incheck where the sensor is on a little incline so it is easy so scan your pass and read the text.

<img src="../../assets/second-design.png" width="300" height="auto">

This design also did not make it because I later deleted the check in button on the left side. I deleted the button because I found it easier to just scan your pass when you want to check in and out, and when you want to go on a break you just press a button first and then scan your pass. And I wanted to hang the machine to the wall and not let it stand on the floor because it won't dominate so much space. It is one handling less and logic for the user. This is just part of the process but I will just place it here because it is a failure too.

## Failure three

I made a test print at Miguel before I wanted to make a final print at the makers lab. When I printed that at Miguel, I saw that I made some mistakes. These mistakes were:

- The design was not totally on the printboard. (I rotated the design in not a very good way)
- The led holes were too small
- I needed to make some extra dept in the layer where the button is to be able to always press it.

<img src="../../assets/frontviewTestPrint.png" width="400" height="auto">

I fixed these dimensions in the final design. The next time for all the designs, I will pay attention that the whole design is on the printbed. You can see that for example in Cura (slicer software) when you put the adhesion on. If you do that and go in "preview", you can see some extra layers next to the first layer of the print.

## Failure four and five

In the last design, the back side also did not make it. That was because when I test printed that part at Miguel, and I saw that the idea I had was very difficult to do. It also had not that very much space for the embedded circuit as I expected. This was that test print for the backside:

<img src="../../assets/backSideTest.jpg" width="400" height="auto">

I quickly came with another idea that will give more room and is easier to make with the magnets I had in mind.
This print went well but wasn't as smooth as I expected.

<img src="../../assets/wholePrint.jpg" width="400" height="auto">

What went wrong was that it didn't connect as smooth as I expected and measured. But this problem is very common with 3D printers because they are just less accurate the laser cutting for example. I leaved this problem for what it was because it is a prototype and not a final product. If you want to take this design further and make it as smooth as it can be, you need to do some extra test prints to make sure you have the exact right dimensions.

## Failure six

The sixt failure is about the button. Although it works (with glue), it could always be better and be done in a differt way. I made a hole for this button where the button cap can be on the front and the switch in the box itself with 1 mm PLA in between. It looked good but I doubted that its going to last long because the 1mm is pretty thin and if I press hard enough it could break, and the backside might come lose because the glue is all the button has to generate force from the back. I was thinking by myself how I could have done this differently the next time and I got an idea. This idea is where the whole button is on the outside of the print in a little square box with 4 mini holes that go through to the inside of the box. When you push the button will have enough resistance on the back so you will always be able to press the button when you want to. The only downside it has is that you need to solder inside the PLA print, which can be a challenge. But a solution for that is to solder 2 thin wires before you put it in the square and put the wires through the holes.

<img src="../../assets/buttonFailure.jpg" width="400" height="auto">

<img src="../../assets/buttonFailureBackView.jpg" width="400" height="auto">

I tried to fix this problem by glueing the button on the 1mm PLA but that did not wnet well. I glued the button so it wasn't be able to click at all anymore. I had to replace the button by soldering it off and a new one on. After that I still had the same problem as before. I fixed this problem by placing a dice behind it with glue. This generates enough backforce to be able to click the button at all times.

Here an image of the glued button:

<img src="../../assets/gluedButton.jpg" width="400" height="auto">

Here an image of the green dice:

<img src="../../assets/greenDice.png" width="400" height="auto">
