# esp8266-12E-DHT

Objective: 
Read the temperature from DHT sensor and populate the HTML file in server, so that it can be seen anywhere from the world. This project uses HTTPclient configuration.

Hardware used:
1. ESP8266MOD development board
2. DHT11 sensor
3. Raspberry Pi 3 (optional)

Software used:
Arduino IDE to program ESP8266 - used nodemcu v1.0 board
Arduino IDE is loaded in the Raspberry Pi 3

Hardware connection ESP8266 to DHT:
Pin2 is used in software config of DHT, which is data pin of the sensor (note: which is D4 in the development board)
Sensor positive is connected 3V3 (next pin to D4 in dev board)
Sensor negative is connected to GND (nect pin to 3V3 in dev board)

Software Configurations:
HTTP basic client logic used in the Arduinoi IDE
Included DHT sensor library

Server side configurations:
created a sub domain iot
if you are using raspberry pi as server ensure permissions is given to read/write from www
use below command
sudo chown -R www-data: *

Raspberry Pi3 as Host
1. Loaded hostapd, dnsmasq and apache, php5 in raspberry pi, 
2. used internal wifi dongle and external wifi dongle created a tunnel to wlan1
sudo iptables -t nat -A POSTROUTING -o wlan1 -j MASQUERADE
3. internal wifi can be used as AP and external dongle to connect to your wifi router

TODO:
1. Connect to MySQL, enable login script php for security
2. You can see the Door Open switch, which can connect the built in LED in esp8266 development board upon button down (onmousedown) and turn off during button up (onmouseup) events





