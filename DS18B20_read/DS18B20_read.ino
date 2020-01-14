#include <DallasTemperature.h>
#include <OneWire.h> 
#include <Ethernet.h>
#include <SPI.h>


#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS); 
DallasTemperature sensors(&oneWire);
unsigned long previousMillis = 0;        // will store last time LED was updated
const long interval = 5000; 
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,1,10);
IPAddress server(192,168,1,4);
EthernetClient client;
float temp = 0;
String data = "";
char c;
char response[5];
String setPoint = "";
float setPointTemp = 0;
int i = 0;

void setup(void) 
{ 
 Serial.begin(9600); 
 Serial.println("hello");
 sensors.begin(); 
 Ethernet.begin(mac);
 delay(1000);
  if (client.connect(server, 80)) 
  {
     client.println("GET /TemperatureControl/read.php?temperatureSetPoint");
     client.println(" HTTP/1.1");
     client.print( "Host: " );
     client.print(server);
     client.println();             
     while(client.available() || client.connected())
     {
      c = client.read();
      if(int(c) >= 46 && int(c) <= 57)
      {
        Serial.println(c);
        response[i] = c;
        i++;
      }
     }
  }
  else
  {
    Serial.println("Connection failed!");
  }
  client.stop();
   setPoint = String(response);
   Serial.println(setPoint);
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
      setPointTemp = atof(response);
      Serial.println(setPointTemp);
      if(setPointTemp < temp + 0.5)
      {
        Serial.println("Heat open");
      }
      else
      {
        Serial.println("Heat closed");
      }
      data = String(temp);
      Serial.print(server);
      Serial.println(setPoint);
          if (client.connect(server, 80)) 
          {
              Serial.println("-> Connected");
              // Make a HTTP request:
              client.print("GET /TemperatureControl/add.php?readTemperature=");
              client.println(data);
              client.println(" HTTP/1.1");
              client.print( "Host: " );
              client.print(server);
              client.println();             
              client.stop();
        }
        else
        {
              Serial.println("--> connection failed/n");
        }
    }
}
