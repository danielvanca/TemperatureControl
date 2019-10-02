#include <OneWire.h> 
#include <DallasTemperature.h>
#include <Ethernet.h>
#include <SPI.h>


#define ONE_WIRE_BUS 2 
OneWire oneWire(ONE_WIRE_BUS); 
DallasTemperature sensors(&oneWire);
unsigned long previousMillis = 0;        // will store last time LED was updated
const long interval = 3600; 
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,1,10);
IPAddress server(192,168,1,6);
EthernetClient client;
float temp = 0;
String data = "";

void setup(void) 
{ 
 Serial.begin(9600); 
 sensors.begin(); 
 Ethernet.begin(mac);
} 
void loop(void) 
{ 
  unsigned long currentMillis = millis();
    if (currentMillis - previousMillis >= interval) 
    {
      previousMillis = currentMillis;
      sensors.requestTemperatures(); // Send the command to get temperature readings 
      Serial.print("Temperature is: "); 
      temp = sensors.getTempCByIndex(0);
      Serial.println(temp); 
      data = String(temp);
      Serial.print(server);

          if (client.connect(server, 80)) 
          {
              Serial.println("-> Connected");
              // Make a HTTP request:
              client.print( "GET /add.php?readTemperature=");
              client.println(data);
              client.println(" HTTP/1.1");
              client.print( "Host: " );
              client.print(server);
              client.println();
              Serial.println( "Connection: close" );
              Serial.println();
              client.stop();
        }
        else
        {
              Serial.println("--> connection failed/n");
        }
      
    }
}

