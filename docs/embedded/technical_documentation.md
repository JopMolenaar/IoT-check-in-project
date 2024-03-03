# Technical documentation

## Wiring Diagram

A wiring diagram is a diagram where people can see how your embbeded system is build. They can see wich parts are used and how it is connected in a diagram that is clear to understand. This is handy when people want to build your project, use pieces of your project, test if their components work and many more things.

I used Fritzing to make my wiring diagram because I never did it and I had no experience with embedded devices and electric circuits.

The wiring of my embedded device was a difficult part for me, that was because I didn't really know where to connect the components and it was not working mulitple times. I got help from many people and searched a lot on the internet but the information was different every time. At the end I based my diagram on that help and these four sources:

- https://randomnerdtutorials.com/esp8266-pinout-reference-gpios/
- https://github.com/miguelbalboa/rfid#pin-layout
- https://www.youtube.com/watch?v=KQiVLEhzzV0
- https://www.viralsciencecreativity.com/post/arduino-rfid-sensor-mfrc522-tutorial

In this diagram the WeMos is connected to two LEDs, one button, an OLED display and a RFID reader to scan cards.
When you scan your card on the RFID reader it will show some text on the display and the LEDs will show the status when you scanned. If you press the button and scan your card on the RFID reader the same thing happens but it is a different function for PHP.

<img src="../../assets/diagram.png" alt="img" width="700" height="auto">

## Bill of Materials

In this BOM you can see all the materials used for this wiring diagram.

| Part #     | Manufacturer | Description                          | Quantity | Price (incl. VAT) | Subtotal (incl. VAT) | Example url                                                                                                                                                                                                  |
| ---------- | ------------ | ------------------------------------ | -------- | ----------------- | -------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| B01M28JAAZ | AZDelivery   | RFID KIT MFRC522 S50 Mifare          | 1        | €8,50             | €8,50                | <a href="https://www.tinytronics.nl/shop/nl/communicatie-en-signalen/draadloos/rfid/rfid-kit-mfrc522-s50-mifare-met-kaart-en-key-tag">Link</a>                                                               |
| B07V9SLQ6W | AZDelivery   | 1.3 inch OLED Display 128\*64 px I2C | 1        | €8                | €8                   | <a href="https://www.tinytronics.nl/shop/nl/displays/oled/1.3-inch-oled-display-128*64-pixels-blauw-i2c">Link</a>                                                                                            |
| B07PZ75N67 | Youmile      | LED                                  | 2        | €0,10             | €0,20                | <a href="https://www.tinytronics.nl/shop/nl/componenten/led's/led's/blauwe-led-3mm-diffuus">Link</a>                                                                                                         |
| WMD1MINIV4 | Lolin        | Wemos D1 mini (v4) ESP8266           | 1        | €7,00             | €7,00                | <a href="https://www.tinytronics.nl/shop/nl/development-boards/microcontroller-boards/met-wi-fi/wemos-d1-mini-v4-esp8266-ch340">Link</a>                                                                     |
| B078JFPGBL | AZDelivery   | Breadboard wires                     | 20       | €0.05             | €1,00                | <a href="https://www.tinytronics.nl/shop/nl/kabels-en-connectoren/kabels-en-adapters/prototyping-draden/dupont-compatible-en-jumper/dupont-jumper-draad-male-male-10cm-10-draden">Link</a>                   |
| B07VCG6Q68 | AZDelivery   | Breadboard 830 points                | 1        | € 6,95            | € 6,95               | <a href="https://www.kiwi-electronics.com/nl/830-punt-breadboard-wit-544?country=NL&utm_term=544&gclid=CjwKCAjw38SoBhB6EiwA8EQVLtEnh5ecBZ4scp3H5lQAI4srRDuxxGiHDXFtR06hub2JDiwfcF9QlRoCTjEQAvD_BwE">Link</a> |
| B0981276BJ | Gedourain    | Large Tact switch button             | 1        | €0.15             | €0.15                | <a href="https://www.tinytronics.nl/shop/nl/schakelaars/manuele-schakelaars/printplaatschakelaars/breadboard-tactile-pushbutton-switch-momentary-2pin-6*6*5mm">Link</a>                                      |
| B088GX1VX6 | CHALA        | Button top piece                     | 1        | €0.15             | €0.15                | <a href="https://www.tinytronics.nl/shop/nl/componenten/knoppen,-doppen-en-kapjes/knopkapje-voor-tactile-pushbutton-switch-momentary-12x12x7.3mm-zwart">Link</a>                                             |
| B01JJ94UVW | SR PASSIVES  | Resistor 220 Ohm                     | 2        | €0,05             | €0,10                | <a href="https://www.tinytronics.nl/shop/index.php?route=product/search&search=Resistor">Link</a>                                                                                                            |
