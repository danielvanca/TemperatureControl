<?php
   	
require "config.php";
 
 $SQL = "INSERT INTO sensors (readTemperature, dateTime) VALUES ('".$_GET["readTemperature"]."', CURRENT_TIMESTAMP)";
if(mysqli_query($conn,$SQL))
{ 
 echo 'Data Submit Successfully';
}
else
{
 echo 'Try Again';
}
$conn->close();
?>
