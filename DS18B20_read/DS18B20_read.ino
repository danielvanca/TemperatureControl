#include <DallasTemperature.h>
#include <OneWire.h> 
#include <Ethernet.h>
#include <SPI.h>
#include <MQUnifiedsensor.h>


#define ONE_WIRE_BUS 3
#define pin A0 //Analog input 0 of your arduino
#define type 135 //MQ135
MQUnifiedsensor MQ135(pin, type);
float CO, Alcohol, CO2, Tolueno, NH4, Acetona;
OneWire oneWire(ONE_WIRE_BUS); 
DallasTemperature sensors(&oneWire);
unsigned long previousMillis = 0;        // will store last time LED was updated
const long interval = 5000; 
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,1,10);
IPAddress server(192,168,1,5);
EthernetClient client;
float temp = 0;
String data = "";
char c;
char response[5]; 
char resetResponse[5];
String setPoint = "";
float setPointTemp = 0;
int i = 0;


void sendData(String data)
{
                // Make a HTTP request:
              client.print("GET /TemperatureControl/add.php?readTemperature=");
              client.println(data);
              client.println(" HTTP/1.1");
              client.print( "Host: " );
              client.print(server);
              client.println();             
              client.stop();
}

void readData()
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
          response[i] = c;
          i++;
        }
     }
   client.stop();
}



void setup(void) 
{ 
 Serial.begin(9600); 
 Serial.println("Welcome!");
 MQ135.inicializar(); 
 sensors.begin(); 
 Ethernet.begin(mac);
 delay(1000);

} 
void loop(void) 
{ 
  unsigned long currentMillis = millis();
    if (currentMillis - previousMillis >= interval) 
    {
        if (client.connect(server, 80)) 
        {
           readData();
           Serial.println("Read-> Connected");
        }
        else
        {
           Serial.println("Read-> connection failed/n");
        }
      previousMillis = currentMillis;
      sensors.requestTemperatures(); // Send the command to get temperature readings 
      Serial.print("Temperature is: "); 
      temp = sensors.getTempCByIndex(0);
      Serial.println(temp);
      setPointTemp = atof(response);

      Serial.print("Temperature Setpoint: ");
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
      Serial.print("Host: ");
      Serial.println(server);
          if (client.connect(server, 80)) 
          {
              sendData(data);
              Serial.println("Send -> Connected");
        }
        else
        {
              Serial.println("Send -> connection failed/n");
        }
        MQ135.update();
        CO =  MQ135.readSensor("CO"); // Return CO concentration
        Alcohol =  MQ135.readSensor("Alcohol"); // Return Alcohol concentration
        CO2 =  MQ135.readSensor("CO2"); // Return CO2 concentration
        Serial.print("CO: ");Serial.print(CO,2);Serial.println(" ppm");
        Serial.print("Alcohol: ");Serial.print(Alcohol,2);Serial.println(" ppm");
        Serial.print("CO2: ");Serial.print(CO2,2);Serial.println(" ppm");
    Serial.println();
    Serial.println();
  }

}
