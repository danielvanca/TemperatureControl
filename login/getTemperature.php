<?php

require "conn2.php";


$mysql_query = "SELECT readTemperature FROM sensors ORDER BY ID DESC LIMIT 1";
$result = mysqli_query($conn, $mysql_query);

if ($result->num_rows > 0)
{
	 while($row = $result->fetch_assoc())
	 {
	 	echo "$row[readTemperature]";
	 }	
	
}
else
{
	echo "0 results";
}

$conn->close();

?>