<?php

require "conn2.php";


 $setpoint = $_POST['setPoint'];


$mysql_query = "INSERT INTO setpoints (temperatureSetPoint, dateTime) VALUES ($setpoint, CURRENT_TIMESTAMP)";

if(mysqli_query($conn,$mysql_query))
{ 
 echo 'Data Submit Successfully';
}
 else
{
 echo 'Try Again';
}
$conn->close();

?>