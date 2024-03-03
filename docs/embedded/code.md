# Embedded code

<!-- This is not a place to put your code, but to describe the code that you have written. You can describe the code in a general way, but also go into detail on specific parts of the code. You can also refer to the code in your repository. So just add a link to the code in your repository. -->

The code structure:

- Includes libaries that are needed.
- Connects to wifi.
- Has functions for shining LED's (some in a loop)
- Has functions for displaying text on the OLED
- The function loop is the main function to check if you scan a card and look if you pushed the button whay you did that. It also waits for incoming requests from the website.
- If you scanned the card it will send data to the API. The API sends a status back and the C++ code will execute some functions based on that status.

<a href="https://gitlab.fdmci.hva.nl/IoT/2023-2024-semester-1/individual-project/iot-molenaj20/-/blob/main/embedded/checkInOutWithCard/checkInCheckOut.ino?ref_type=heads">Link to the code</a>

Some little explaination of part of the code:

This fires when you scan a card:

```cpp
  // Get and print cardId
  Serial.print(F("Card UID:"));
  dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  String concatenatedValue = concatenate_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  Serial.println();
  String cardId = concatenatedValue;

  // Read the button state every time a card is scanned
  buttonState = digitalRead(buttonCheckIn);

  // fire the function en say if the button is pressed or not
  if (buttonState == HIGH) {
    Serial.println("Button pressed");  // Button pressed for getting a break
    gettingBreak = true;
    displayTextOnOled("Loading...");
    sendToApi(gettingBreak, cardId);
  } else {
    Serial.println("Button not pressed");
    gettingBreak = false;
    displayTextOnOled("Loading...");
    sendToApi(gettingBreak, cardId);
  }
```

In the code above you see lines which are fired when you scan your card. The frist part gets the cardId of the card you scanned. After that it looks if the button is pressed or not when you scan your card. It changes the value of the variable **gettingBreak** and runs a function which changes the content on the oled to show the user he/she scanned his/her card. After that a function runs with the variable **gettingBreak** and the **cardId** of the card he/she scanned as parameters.

sendToApi(gettingBreak, cardId); is a function which sends this data to the API and gets a respond.
Dependent on what respond it gets, it will run various functions to show feedback to the user such as text on the oled screen and a status from the green and red LED's.

In the loop function it will also wait for incoming requests from the website. If you click the test button on the website it will run a test on the OLED and LED's.

```cpp
WiFiClient client = server.available();  // Listen for incoming clients

  if (client) {                     // If a new client connects,
    Serial.println("New Client.");  // print a message out in the serial port
    String currentLine = "";        // make a String to hold incoming data from the client
    currentTime = millis();
    previousTime = currentTime;
    while (client.connected() && currentTime - previousTime <= timeoutTime) {  // loop while the client's connected
      currentTime = millis();
      if (client.available()) {  // if there's bytes to read from the client,
        char c = client.read();  // read a byte, then
        Serial.write(c);         // print it out the serial monitor
        header += c;
        if (c == '\n') {  // if the byte is a newline character
          // if the current line is blank, you got two newline characters in a row.
          // that's the end of the client HTTP request, so send a response:
          if (currentLine.length() == 0) {
            // HTTP headers always start with a response code (e.g. HTTP/1.1 200 OK)
            // and a content-type so the client knows what's coming, then a blank line:
            client.println("HTTP/1.1 200 OK");
            client.println("Content-type:text/html");
            client.println("Connection: close");
            client.println();

            if (header.indexOf("GET /test") >= 0) {
              Serial.println("test");
              displayTextOnOled("Testing...");
              interactionLed(ledGreen, blinkFrequencyLong, littleDelay);
              interactionLed(ledRed, blinkFrequencyLong, littleDelay);
              interactionLed(ledGreen, blinkFrequencyLong, littleDelay);
              interactionLed(ledRed, blinkFrequencyLong, littleDelay);
            }
            break;
          } else {  // if you got a newline, then clear currentLine
            currentLine = "";
          }
        } else if (c != '\r') {  // if you got anything else but a carriage return character,
          currentLine += c;      // add it to the end of the currentLine
        }
      }
    }
    // Clear the header variable
    header = "";
    // Close the connection
    client.stop();
    Serial.println("Client disconnected.");
    Serial.println("");
  }
```
