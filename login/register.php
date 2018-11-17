<?php

require "conn.php";

$username = $_POST["user_name"];
$password = $_POST["password"];
$mysql_query = "INSERT INTO loginregister (user, pwd) VALUES ('$username', '$password);
$result = mysqli_query($conn, $mysql_query);

if (mysqli_num_rows($result) > 0)
{
	echo "Login successfuly!";
}
else
{
	echo "Login failed!";
}

?>