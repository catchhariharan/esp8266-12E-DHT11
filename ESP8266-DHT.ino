/**
 * BasicHTTPClient.ino
 *
 *  Created on: 24.05.2015
 *
 */

#include <Arduino.h>

#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <ESP8266HTTPClient.h>

#define USE_SERIAL Serial

ESP8266WiFiMulti WiFiMulti;

#include <DHT.h>

#define DHTPIN            2         // Pin which is connected to the DHT sensor.

// Uncomment the type of sensor in use:
#define DHTTYPE           DHT11     // DHT 11 
//#define DHTTYPE           DHT22     // DHT 22 (AM2302)
//#define DHTTYPE           DHT21     // DHT 21 (AM2301)



String server = "http://svaasya.com/iot/";
String myAP;
String payload = "";      

unsigned long previousMillis = 0;        // will store last time was updated
unsigned long currentMillis = 0;        // will store last time was updated
const long interval = 10000;           // interval at which to blink (milliseconds)

DHT dht(DHTPIN, DHTTYPE);

void setup() {
    
    pinMode(LED_BUILTIN, OUTPUT);     // Initialize the LED_BUILTIN pin as an output

    USE_SERIAL.begin(115200);
   // USE_SERIAL.setDebugOutput(true);

    USE_SERIAL.println();
    USE_SERIAL.println();
    USE_SERIAL.println();

    for(uint8_t t = 4; t > 0; t--) {
        USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
        USE_SERIAL.flush();
        delay(1000);
    }
    
//    WiFiMulti.addAP("HariRedmi", "hari0512");
    WiFiMulti.addAP("Pi3-AP", "ganesh0706");
    
    if(WiFiMulti.run() == WL_CONNECTED) {
        USE_SERIAL.println("");
        USE_SERIAL.println("WiFi connected");
        USE_SERIAL.println("IP address: ");
        USE_SERIAL.println(WiFi.localIP());
        USE_SERIAL.println(WiFi.SSID());
    }
    
    dht.begin();
}

void loop() {

    if((WiFiMulti.run() == WL_CONNECTED)) {
        //Try to make the one LED to Green saying WL connected
        myAP = WiFi.SSID();
        myAP.trim();
        checkhttpconnection(); 
    }
    delay (50);

}

void checkhttpconnection() {

    HTTPClient http;  

    USE_SERIAL.print("[HTTP] begin...\n");
    http.begin(server + "DoorSts.txt"); //HTTP
    
    int httpCode = http.GET();
    USE_SERIAL.printf("[HTTP] GET... code: %d\n", httpCode);
    
    // httpCode will be negative on error
    if(httpCode > 0) {
        if(httpCode == HTTP_CODE_OK) {
          payload = http.getString();
          ActuateDoor();
        }
        
        currentMillis = millis();
        if (currentMillis - previousMillis >= interval) {
        // save the last time you blinked the LED
        previousMillis = currentMillis;


        // Reading temperature or humidity takes about 250 milliseconds!
        // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
        float h = dht.readHumidity();
        // Read temperature as Celsius (the default)
        float t = dht.readTemperature();
        // Read temperature as Fahrenheit (isFahrenheit = true)
        float f = dht.readTemperature(true);
      
        // Check if any reads failed and exit early (to try again).
        if (isnan(h) || isnan(t) || isnan(f)) {
          Serial.println("Failed to read from DHT sensor!");
          return;
        }
      
        // Compute heat index in Fahrenheit (the default)
        float hif = dht.computeHeatIndex(f, h);
        // Compute heat index in Celsius (isFahreheit = false)
        float hic = dht.computeHeatIndex(t, h, false);
      
        Serial.print("\nHumidity: ");
        Serial.print(h);
        Serial.print(" %\t");
        Serial.print("Temperature: ");
        Serial.print(t);
        Serial.print(" *C ");
        Serial.print(f);
        Serial.print(" *F\t");
        Serial.print("Heat index: ");
        Serial.print(hic);
        Serial.print(" *C ");
        Serial.print(hif);
        Serial.println(" *F\n");        
    
        String Humidity = String(h);
        String Temperature_Cel = String(t);
        String Temperature_Fehr = String(f);
        String HeatIndex_Cel = String(hic);
        String HeatIndex_Fehr = String(hif);
    
        String data = "Humidity="
              +                        (String) Humidity
              +  "&Temperature_Cel="  +(String) Temperature_Cel
              +  "&Temperature_Fehr=" +(String) Temperature_Fehr
              +  "&HeatIndex_Cel="    +(String) HeatIndex_Cel
              +  "&HeatIndex_Fehr="   +(String) HeatIndex_Fehr;
    
        
        USE_SERIAL.print("\n [HTTP] begin...\n");
        http.begin(server + "dataCollector.php");
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        http.POST(data);
        http.writeToStream(&Serial);
      }        

    } else {
        USE_SERIAL.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
    
    http.end();
    USE_SERIAL.print("\n[HTTP] END...\n"); 
  
}

void ActuateDoor() {

      payload.trim();
      USE_SERIAL.print("\n[ACTUATOR] Control Value: ");
      if (payload == "Open"){
        digitalWrite(LED_BUILTIN, LOW);   // Turn the LED on (Note that LOW is the voltage level
        USE_SERIAL.print(payload);
      }
      else if (payload == "Close"){
        digitalWrite(LED_BUILTIN, HIGH);   // Turn the LED off (Note that LOW is the voltage level
        USE_SERIAL.print(payload);
      }
      else {
        USE_SERIAL.print(payload);
        USE_SERIAL.print(" Not Good");
      }



  


}

