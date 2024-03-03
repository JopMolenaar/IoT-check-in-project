/* 
Name author: Jop Molenaar
Email author: jopmolenaar@icloud.com
Description: When you scan a card with the RFID reader, data will be sended to the api and if you get acces or not LEDs will burn and text will show on the OLED
License: MIT license
*/


// All the includes
#include <MFRC522.h>            // for the RFID reader
#include <ESP8266HTTPClient.h>  // for http request
#include <U8g2lib.h>            // for the OLED
#include <WiFiManager.h>        // for the wifi manager
#include <ArduinoJson.h>        // for JSON messages form the API
#include <ESP8266WiFi.h>        // for letting the WeMos listen to requests

// Address of the OLED screen for u8g2
U8G2_SH1106_128X64_NONAME_1_HW_I2C u8g2(U8G2_R0, /* reset=*/U8X8_PIN_NONE);

// Web server on port 80
WiFiServer server(80);

// Replace with your network credentials (This is for the wifi that the WeMos needs to listen to requests)
const char* ssid = "wifiNetwork";
const char* password = "password";

// Variable to store the incoming HTTP request
String header;

// Current time
unsigned long currentTime = millis();
// Previous time
unsigned long previousTime = 0;
// Define timeout time in milliseconds (example: 2000ms = 2s)
const long timeoutTime = 2000;


// Pins
const int ledGreen = 3;
const int ledRed = 2;
const int buttonCheckIn = 16;
constexpr uint8_t RST_PIN = D3;
constexpr uint8_t SS_PIN = D8;
MFRC522 mfrc522(SS_PIN, RST_PIN);


// All the numbers used for delay, baud and loop
const int ultraSmallDelay = 10;
const int littleDelay = 200;
const int delayHalfSecond = 500;
const int delayOneSecond = 1000;
const int delayThreeSeconds = 3000;
const int baudRate = 115200;
const int blinkFrequencyLong = 4;
const int noBlinkFrequency = 1;
const int repeatOneTime = 1;
const int noWaitingTime = 0;
const int waitSecondsEnd = 0;
const int nullTerminator = 1;
int buttonState = 0;  // Button state, 0 = not pressed, 1 = pressed

bool gettingBreak = false;  // getting a brake is default false

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

/* 
Send card id with extra data about break to the API and getting status back from PHP
@gettingBreak Is a boolean that says if you are going on a break or not
@cardId Is the card id of your card that you have scanned on the RFID reader
*/
void sendToApi(bool gettingBreak, String cardId) {

  // Initialize a wi-fi client & http client
  WiFiClient wifiClient;
  HTTPClient httpClient;

  // API
  httpClient.begin(wifiClient, "http://molenaj20.loca.lt/api.php");
  httpClient.addHeader("Content-Type", "application/x-www-form-urlencoded");


  // Send card id and the data getting a break or not to the API
  String httpRequestData = "cardId=" + String(cardId) + "&Break=" + String(gettingBreak);
  int httpResponseCode = httpClient.POST(httpRequestData);

  if (httpResponseCode == HTTP_CODE_OK) {     // HTTP_CODE_OK == 200
    String payload = httpClient.getString();  // Get the body of the GET-request response.
    // Parse the JSON string into a JSON object
    StaticJsonDocument<200> doc;  // Specify the size based on your JSON content
    DeserializationError error = deserializeJson(doc, payload);

    if (error) {
      Serial.print("Error parsing JSON: ");
      Serial.println(error.c_str());
    } else {
      // Access JSON object elements
      const char* message = doc["message"];
      String trimmedMessage = message;
      trimmedMessage.trim();

      bool success = doc["success"];

      // Do something with the parsed data
      if (success) {
        Serial.print("Success! Message: ");
        Serial.println(success);
        Serial.println(trimmedMessage);

        if (trimmedMessage == "Added start break time") {
          displayTextOnOled("See you soon");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Getting to work again") {
          displayTextOnOled("Welcome back");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Added to database") {
          const char* name = doc["name"];                                            // Assuming doc["name"] is a const char* containing the name
          const char* welcomeText = "Welcome ";                                      // String to concatenate
          size_t totalLength = strlen(welcomeText) + strlen(name) + nullTerminator;  // Calculate the length of the concatenated string, +1 for the null terminator
          char concatenatedString[totalLength];                                      // Allocate memory for the concatenated string
          strcpy(concatenatedString, welcomeText);                                   // Copy the welcome text to the concatenated string
          strcat(concatenatedString, name);                                          // Concatenate the name to the concatenated string
          displayTextOnOled(concatenatedString);                                     // Now, concatenatedString contains "Welcome " followed by the name
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "Checked out") {
          displayTextOnOled("Have a good day!");
          interactionLed(ledGreen, noBlinkFrequency, delayThreeSeconds);
        } else {
          displayTextOnOled("There is an error");
          Serial.println(trimmedMessage);
          interactionLed(ledRed, blinkFrequencyLong, littleDelay);
        }
      } else {
        Serial.print("Error! Message: ");
        Serial.println(trimmedMessage);

        if (trimmedMessage == "No employee") {
          displayTextOnOled("No access");
          interactionLed(ledRed, noBlinkFrequency, delayThreeSeconds);
        } else if (trimmedMessage == "First need to check in") {
          displayTextOnOled("Please check in first");
          interactionLed(ledRed, noBlinkFrequency, delayThreeSeconds);
        } else {
          displayTextOnOled("There is an error");
          Serial.println(trimmedMessage);
          interactionLed(ledRed, blinkFrequencyLong, littleDelay);
        }
      }
    }
  } else {
    Serial.println("Unable to connect :(");
    displayTextOnOled("no wifi");
    interactionLed(ledRed, blinkFrequencyLong, littleDelay);
    Serial.println(httpResponseCode);
  }
}


// Setup where wifi is connected, pins get aknoledged, libaries are started
void setup(void) {
  Serial.begin(baudRate);
  delay(ultraSmallDelay);

  // Connect to Wi-Fi network with SSID and password
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  // Print local IP address and start web server
  Serial.println("");
  Serial.println("WiFi connected.");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  // Connect WiFi -> wifimanager
  connectWifi();
  server.begin();

  // Print the IP address
  Serial.print("IP address: ");
  Serial.print(WiFi.localIP());
  delay(delayOneSecond);
  Serial.println("Setup");


  // Aknoledged pins
  pinMode(ledGreen, FUNCTION_3);  // RX pin is used also used to receive communication on the WeMos, but is set to FUNCTION_3 to use as a GPOI pin. Read more: https://www.esp8266.com/wiki/doku.php?id=esp8266_gpio_pin_allocations
  pinMode(ledGreen, OUTPUT);
  pinMode(ledRed, OUTPUT);
  pinMode(buttonCheckIn, INPUT_PULLUP);


  // Start libaries
  SPI.begin();
  mfrc522.PCD_Init();
  mfrc522.PCD_DumpVersionToSerial();
  Serial.println(F("Scan PICC to see UID, SAK, type, and data blocks..."));
  u8g2.begin();

  Serial.println("Setup done");
}

// main function for when you scan your card and text and LEDs will show feedback to the user, it also listens to incoming requests to run a test function
void loop(void) {
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

  // Show text instantly on OLED
  displayTextOnOled("Check in...");


  // If no card is scanned, return nothing.
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }

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
}



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