# Requirements

<!--
To build your embedded device you need to have a clear idea of the requirements. On this page you can describe the requirements of your embedded device. This includes the requirements from DLO, but also your own requirements.

Add some images! 😉 -->

## Requirements embedded device

| Requirement ID# | Requirement                                                                                                                                                   | MoSCoW | Compliant |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------ | --------- |
| EMBRQ#01        | Embedded device sends measured sensordata to the application backend over http or https.                                                                      | MUST   | YES       |
| EMBRQ#02        | Embedded device receives or retrieves status messages from the application backend over http or https.                                                        | MUST   | YES       |
| EMBRQ#03        | The embedded device contains at least two input sensors (e.g. LDR, buttons, joystick, capacitive touch, etc.).                                                | MUST   | YES       |
| EMBRQ#04        | The embedded device contains at least two visual and/or sensory outputs (e.g. LED, LED Matrix, 7-segement display, motor, servo, actuator, LCD-screen, etc.). | MUST   | YES       |
| EMBRQ#05        | The embedded device uses the wifi manager for configuration of SSID, User ID (UID) en Password (PWD) for connecting to the network.                           | MUST   | YES       |
| EMBRQ#06        | The machine must provide feedback to the user by displaying his/her name.                                                                                     | MUST   | YES       |
| EMBRQ#07        | The machine must let the user know if he/she checked in or out by displaying "Welcome" or "Have a good day".                                                  | MUST   | YES       |
| EMBRQ#08        | The machine must provide feedback to the user by letting the status of the check in/out know by using green and red LED's.                                    | MUST   | YES       |
| EMBRQ#09        | The machine should respond with text on the screen and a burning led in 5 seconds.                                                                            | SHOULD | YES       |
| EMBRQ#10        | The embedded device needs to let the user know that the card is scanned when the card is scanned.                                                             | MUST   | YES       |
| EMBRQ#11        | The wires used in my embedded device for ground and power must be color coded.                                                                                | MUST   | YES       |
| EMBRQ#12        | The wires used in my embedded device should be color coded.                                                                                                   | SHOULD | NO        |

### EMBRQ#01

The embedded device sends measured sensordata to the application backend over http when you scan your card to the RFID reader. The embedded device will get your card id and if you want a break or not (by pressing the button or not) and will send this to the API via http using the libary: ESP8266HTTPClient.h.

Code:

```cpp
  // Initialize a wi-fi client & http client
  WiFiClient wifiClient;
  HTTPClient httpClient;

  // API
  httpClient.begin(wifiClient, "http://molenaj20.loca.lt/api.php");
  httpClient.addHeader("Content-Type", "application/x-www-form-urlencoded");


  // Send card id and the data getting a break or not to the API
  String httpRequestData = "cardId=" + String(cardId) + "&Break=" + String(gettingBreak);
  int httpResponseCode = httpClient.POST(httpRequestData);

  // Get and print cardId
  Serial.print(F("Card UID:"));
  dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  String concatenatedValue = concatenate_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  Serial.println();
  String cardId = concatenatedValue;
```

The sensor data that I am reading is the cardId, I reading that with this piece code:

```cpp
// RFID code
String concatenate_byte_array(byte* buffer, byte bufferSize) {
  String concatenatedHexValue = "";  // Initialize an empty string to store the concatenated hex value
  for (byte i = 0; i < bufferSize; i++) {
    // Construct the hexadecimal value with leading zeros
    String hexByte = String(buffer[i], HEX);
    if (buffer[i] < 0x10) {
      hexByte = "0" + hexByte;
    }
    // Add the hexadecimal byte to the concatenated value
    concatenatedHexValue += hexByte;
  }
  // Return the concatenated value as a string
  return concatenatedHexValue;
}

void dump_byte_array(byte* buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
    Serial.print(buffer[i] < 0x10 ? " 0" : " ");
    Serial.print(buffer[i], HEX);
  }
}
```

And in the loop function I am running this function and storing it in the cardId variable:

```cpp
  // Get and print cardId
  Serial.print(F("Card UID:"));
  dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  String concatenatedValue = concatenate_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  Serial.println();
  String cardId = concatenatedValue;
```

### EMBRQ#02

The embedded device receives status messages from the application backend over http. When sended data to the API, the API sends data back over http with status messages like: "Checked out", "Added to database" and "First need to check in", etc using the libary: ESP8266HTTPClient.h.

Code:

```cpp
  if (httpResponseCode == HTTP_CODE_OK) {     // HTTP_CODE_OK == 200
    String payload = httpClient.getString();  // Get the body of the GET-request response.
    Serial.println("payload: ");
    Serial.println(payload);  // Print the body of the GET-request response.

    if (payload.indexOf("Added start break time") != -1) {
      displayTextOnOled("Untill soon");
      interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
    } else if (payload.indexOf("No employee") != -1) {
      displayTextOnOled("No access");
      interactionLed(ledRed, noBlinkFrequency, delayThreeSeconds);
    } else if (payload.indexOf("Getting to work again") != -1) {
      displayTextOnOled("Welcome back");
      interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
    } else if (payload.indexOf("First need to check in") != -1) {
      displayTextOnOled("Please check in first");
      interactionLed(ledRed, noBlinkFrequency, delayThreeSeconds);
    } else if (payload.indexOf("Added to database") != -1) {
      welcomeWithName(payload);
      interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
    } else if (payload.indexOf("Checked out") != -1) {
      displayTextOnOled("Bye, have a good day!");
      interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
    } else {
      displayTextOnOled("There is an error");
      interactionLed(ledRed, blinkFrequencyLong, littleDelay);
    }
  } else {
    Serial.println("Unable to connect :(");
    displayTextOnOled("no wifi");
    interactionLed(ledRed, blinkFrequencyLong, littleDelay);
    Serial.println(httpResponseCode);
  }
```

Almost at the end of these 10 weeks Gerald send a message via DLO that this code above was not how this rerquirement should be fulfilled. The WeMos should have had listened to requests and act like a server. I tried to implement that but I had lots of troubles with it. I could not let the WiFiManager listen to server requests and the link that Gerald had send in the message about this requirement on DLO was using the ESP8266WiFi.h library. Some weeks before this, I had deleted this way of getting wifi and implemented the Wifi manager but now I had no other choise to paste it back into my code. Sorry Gerald that I have now two ways of getting wifi in my code but I could not get it to work in an other way. Anyway, I implemented this piece of code in the loop to let it listen to http GET requests and run a test on the Oled and Led's:

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

### EMBRQ#03

The embedded device contains at least two input sensors and these are: RFID reader KIT MFRC522 S50 Mifare and a button.

<img src="../../assets/embReqImg.jpg" alt="" width="400" height="auto">

Code RFID reader in the loop function:

```cpp
  // If no card is scanned, return nothing.
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }
```

The sensor data that I am reading is the cardId, I reading that with this piece code:

```cpp
// RFID code
String concatenate_byte_array(byte* buffer, byte bufferSize) {
  String concatenatedHexValue = "";  // Initialize an empty string to store the concatenated hex value
  for (byte i = 0; i < bufferSize; i++) {
    // Construct the hexadecimal value with leading zeros
    String hexByte = String(buffer[i], HEX);
    if (buffer[i] < 0x10) {
      hexByte = "0" + hexByte;
    }
    // Add the hexadecimal byte to the concatenated value
    concatenatedHexValue += hexByte;
  }
  // Return the concatenated value as a string
  return concatenatedHexValue;
}

void dump_byte_array(byte* buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
    Serial.print(buffer[i] < 0x10 ? " 0" : " ");
    Serial.print(buffer[i], HEX);
  }
}
```

And in the loop function I am running this function and storing it in the cardId variable:

```cpp
  // Get and print cardId
  Serial.print(F("Card UID:"));
  dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  String concatenatedValue = concatenate_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size);
  Serial.println();
  String cardId = concatenatedValue;
```

Code button:

```cpp
  // Read the button state every time a card is scanned
  buttonState = digitalRead(buttonCheckIn);

  // fire the function en say if the button is pressed or not
  if (buttonState == HIGH) {
    Serial.println("Button pressed");  // Button pressed for getting a break
    gettingBreak = true;
    sendToApi(gettingBreak, cardId);
  } else {
    Serial.println("Button not pressed");
    gettingBreak = false;
    sendToApi(gettingBreak, cardId);
  }
```

### EMBRQ#04

The embedded device contains at least two visual and/or sensory outputs and these are: two LEDs and a 1.3 inch OLED 128\*64 px I2C display.

<img src="../../assets/twoOutputs.png" alt="" width="400" height="auto">

Code:

```cpp
/*
Function to display the text on the Oled screen
@text Is a string that should be written on the OLED
*/
void displayTextOnOled(const char* text) {
  u8g2.firstPage();
  do {
    u8g2.setFont(u8g2_font_ncenB10_tr);
    u8g2.drawStr(0, 24, text);
  } while (u8g2.nextPage());
}
```

And I am calling for example this function to display text on the oled:

```cpp
displayTextOnOled("Check in...");
```

Here is the function for the LED's:

```cpp
/*
Functions for LED states text
@led Is the led pin of the led that should give light
@frequency Is the frequency of how many times the loop has to repeat
@waitSeconds Are the second that you have to wait before the light will go off
*/
void interactionLed(int led, int frequency, int waitSeconds) {
  if (frequency == repeatOneTime) {
    waitSecondsEnd == noWaitingTime;
  } else {
    waitSecondsEnd == waitSeconds;
  }
  for (int i = 0; i < frequency; ++i) {
    digitalWrite(led, HIGH);
    delay(waitSeconds);
    digitalWrite(led, LOW);
    delay(waitSecondsEnd);
  }
}
```

And here is how I am calling this function for example:

```cpp
interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
```

### EMBRQ#05

The embedded device uses the wifi manager for configuration of SSID, User ID (UID) en Password (PWD) for connecting to the network using the libary: WiFiManager.h.

It creates a network called "checkInOut" and if you connect to it with using another device and go to this: 192.168.4.1 IP adress you can log in with the wifi SSID and password.

Code:

```cpp
#include <WiFiManager.h>        // for the wifi manager

// connect wifi via wifimanager
void connectWifi() {
  WiFi.mode(WIFI_STA);

  WiFiManager wifiManager;

  bool check;

  check = wifiManager.autoConnect("checkInOut");
  if (!check) {
    Serial.println("failed");
  } else {
    Serial.println("connected");
  }
}
```

And in the setup I am running this function:

```cpp
  // Connect WiFi -> wifimanager
  connectWifi();
```

### EMBRQ#06

The machine provides feedback to the user by displaying his/her name by getting the name from the JSON answer from PHP and giving it to displayTextOnOled():

```cpp
const char* name = doc["name"]; // Assuming doc["name"] is a const char* containing the name
const char* welcomeText = "Welcome "; // String to concatenate
size_t totalLength = strlen(welcomeText) + strlen(name) + 1;  // Calculate the length of the concatenated string, +1 for the null terminator
char concatenatedString[totalLength]; // Allocate memory for the concatenated string
strcpy(concatenatedString, welcomeText);// Copy the welcome text to the concatenated string
strcat(concatenatedString, name); // Concatenate the name to the concatenated string
displayTextOnOled(concatenatedString);
```

### EMBRQ#07

The machine lets the user know if he/she checked in or out by displaying "Welcome" or "Have a good day" in this function:

```cpp
if (trimmedMessage == "Added start break time") {
          displayTextOnOled("See you soon");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Getting to work again") {
          displayTextOnOled("Welcome back");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Added to database") {
          const char* name = doc["name"];// Assuming doc["name"] is a const char* containing the name
          const char* welcomeText = "Welcome ";// String to concatenate
          size_t totalLength = strlen(welcomeText) + strlen(name) + nullTerminator;  // Calculate the length of the concatenated string, +1 for the null terminator
          char concatenatedString[totalLength]; // Allocate memory for the concatenated string
          strcpy(concatenatedString, welcomeText);// Copy the welcome text to the concatenated string
          strcat(concatenatedString, name);// Concatenate the name to the concatenated string
          displayTextOnOled(concatenatedString); // Now, concatenatedString contains "Welcome " followed by the name
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Checked out") {
          displayTextOnOled("Have a good day!");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else {
          displayTextOnOled("There is an error");
          Serial.println(trimmedMessage);
          interactionLed(ledRed, blinkFrequencyLong, littleDelay);
        }
```

### EMBRQ#08

The machine provides feedback to the user by letting the status of the check in/out know by using green and red LED's using this function:

```cpp
/*
Functions for LED states text
@led Is the led pin of the led that should give light
@frequency Is the frequency of how many times the loop has to repeat
@waitSeconds Are the second that you have to wait before the light will go off
*/
void interactionLed(int led, int frequency, int waitSeconds) {
  if (frequency == repeatOneTime) {
    waitSecondsEnd == noWaitingTime;
  } else {
    waitSecondsEnd == waitSeconds;
  }
  for (int i = 0; i < frequency; ++i) {
    digitalWrite(led, HIGH);
    delay(waitSeconds);
    digitalWrite(led, LOW);
    delay(waitSecondsEnd);
  }
}
```

<img src="../../assets/frontSide.jpg" alt="" width="300" height="auto">

### EMBRQ#09

The machine responds with text on the screen and a burning led in 5 seconds. I timed it and most of the time it was around 1-3 seconds.

### EMBRQ#10

The embedded device lets the user know that the card is scanned when the card is scanned by firing this when the card is scanned:

```cpp
displayTextOnOled("Loading...");
```

### EMBRQ#11

The wires used in my embedded device for ground and power are color coded. For ground I used black and for VCC I used red like it should.

<img src="../../assets/littleBoard.jpg" alt="" width="400" height="auto">
