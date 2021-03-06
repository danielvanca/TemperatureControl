<?php
   
    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbName = "temperatures";
    $conn = new mysqli($servername, $username, $password, $dbName);
   
    if ($conn->connect_error) 
    {
      die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT temperatureSetPoint, dateTime FROM setpoints LIMIT 25";
    $result = $conn->query($query);

    $jsonArray = array();

    if ($result->num_rows > 0) 
    {
      while($row = $result->fetch_assoc()) 
      {
        $jsonArrayItem = array();
        $jsonArrayItem['label'] = $row['dateTime'];
        $jsonArrayItem['value'] = $row['temperatureSetPoint'];
        array_push($jsonArray, $jsonArrayItem);
      }
    }
    $conn->close();
    header('Content-type: application/json');
    echo json_encode($jsonArray);
?>