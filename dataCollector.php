<?php

/*
  ESP8266: send data to your Domain (or mine: Embedded-iot.net/dht11/dataCollector.php)(

  Uses POST command to send DHT data to a designated website
  The circuit:
  * DHT
  * Post to Domain

   Stephen Borsay
   Embedded-iot.net
   www.udemy.com/all-about-arduino-wireless
   https://www.hackster.io/detox
   https://github.com/sborsay/Arduino_Wireless
*/
date_default_timezone_set("Asia/Kolkata");
$TimeStamp = "The last updated date and time is " . date("h:i:sa") . "(IST)" ;
file_put_contents('dataDisplayer.html', $TimeStamp);


//   if( $_REQUEST["Humidity"] ||  $_REQUEST["Temperature_Cel"] ||  $_REQUEST["Temperature_Fehr"]
//       ||  $_REQUEST["HeatIndex_Cel"] ||  $_REQUEST["HeatIndex_Fehr"] ) 
//   {
      echo " The Humidity is: ". $_REQUEST['Humidity']. "%<br />";
      echo " The Temperature is: ". $_REQUEST['Temperature_Cel']. " Celcius<br />";
      echo " The Temperature is: ". $_REQUEST['Temperature_Fehr']. " Fehrenheit<br />";
      echo " The Heat Index is: ". $_REQUEST['HeatIndex_Cel']. " Heat Index Celcius<br />";
      echo " The Heat Index is: ". $_REQUEST['HeatIndex_Fehr']. " Heat Index Fehrenheit<br />";
//   }
	  
	
$var1 = $_REQUEST['Humidity'];
$var2 = $_REQUEST['Temperature_Cel'];
$var3 = $_REQUEST['Temperature_Fehr'];
$var4 = $_REQUEST['HeatIndex_Cel'];
$var5 = $_REQUEST['HeatIndex_Fehr'];

$WriteMyRequest=
"<p> The Humidity is : "    . $var1 . "% </p>".
"<p> The Temperature is : " . $var2 . " Celcius </p>".
"<p> The Temperature is : " . $var3 . " Fehreinheit</p>".
"<p> The Heat Index is : "  . $var4 . " Heat Index Celcius </p>".
"<p> The Heat Index is : "  . $var5 . " Heat Index Fehrenheit </p><br/>";


file_put_contents('dataDisplayer.html', $WriteMyRequest,FILE_APPEND);


?>
