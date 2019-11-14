<?php
   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "temperatures";
    $conn = new mysqli($servername, $username, $password, $dbName);
   
    if ($conn->connect_error) 
    {
      die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT readTemperature, dateTime FROM sensors LIMIT 25";
    $result = $conn->query($query);

    $jsonArray = array();

    if ($result->num_rows > 0) 
    {
      while($row = $result->fetch_assoc()) 
      {
        $jsonArrayItem = array();
        $jsonArrayItem['label'] = $row['dateTime'];
        $jsonArrayItem['value'] = $row['readTemperature'];
        array_push($jsonArray, $jsonArrayItem);
      }
    }
    $conn->close();
    header('Content-type: application/json');
    echo json_encode($jsonArray);
?>