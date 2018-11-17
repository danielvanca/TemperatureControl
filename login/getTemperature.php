<?php

require "conn2.php";


$mysql_query = "SELECT readTemperature FROM sensors ORDER BY ID DESC LIMIT 1";
$result = mysqli_query($conn, $mysql_query);

if ($result->num_rows > 0)
{
	echo "readTemperature: " . $rows["readTemperature"]. "<br>";
}
else
{
	echo "0 results";
}
conn->close();

?>