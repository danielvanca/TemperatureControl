<?php

require "conn.php";

$user_name = $_POST["user_name"];
$user_pwd = $_POST["password"];
$mysql_query = "SELECT * FROM loginregister WHERE user LIKE '$user_name' AND pwd LIKE '$user_pwd'";
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