const int PIR_PIN = A1;               //PIR sensor is connected to analog pin A1
int reading;
String apiKey = "3NJBZ896N5VTBHDE";

void setup() {
  Serial.begin(9600);
  pinMode(PIR_PIN, INPUT);
  // Connect to Wi-Fi
  connectToWiFi();
}

void loop() {
  reading = analogRead(PIR_PIN);
  sendDataToThingSpeak(reading);
  delay(15000);                     // ThingSpeak needs 15 seconds delay between updates
}

void connectToWiFi() {
  Serial.println("AT+RST");
  delay(1000);
  Serial.println("AT+CIPMUX=0");
  delay(1000);
}

void sendDataToThingSpeak(int pirData) {
  Serial.print("AT+CIPSTART=\"TCP\",\"api.thingspeak.com\",80\r\n");
  delay(1000);
  
  if (Serial.find("Error")) {
    Serial.println("AT+CIPSTART error");
    return;
  }
  
  String getStr = "GET /update?api_key=";
  getStr += apiKey;
  getStr += "&field1=";
  getStr += String(pirData);
  getStr += "\r\n\r\n";
  
  String cmd = "AT+CIPSEND=";
  cmd += String(getStr.length());
  Serial.println(cmd);
  delay(500);
  
  if (Serial.find(">")) {
    Serial.print(getStr);
  } else {
    Serial.println("AT+CIPCLOSE");
  }
  
  delay(15000);                         //  15 seconds delay to send data
}
