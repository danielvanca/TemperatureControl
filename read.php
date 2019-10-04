<?php

require "config.php";


$mysql_query = "SELECT temperatureSetPoint FROM setpoints ORDER BY ID DESC LIMIT 1";
$result = mysqli_query($conn, $mysql_query);

if ($result->num_rows > 0)
{
	 while($row = $result->fetch_assoc())
	 {
	 	echo "$row[temperatureSetPoint]";
	 }	
	
}
else
{
	echo "0 results";
}

$conn->close();

?>