<?php

require "conn.php";

$username = $_POST["user_name"];
$password = $_POST["password"];
$mysql_query = "INSERT INTO loginregister (user, pwd) VALUES ('$username', '$password')";


if($conn->query($mysql_query) === TRUE)
{
	echo "Registration successfull!";
}
else
{
	echo "Error: " . $mysql_query . "</br>" . $conn->error;
}

$conn->close();

?>