<?php
    
      
    include 'config.php';

    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "INSERT INTO loginregister (user, pwd) VALUES ('$_POST[user]', '$_POST[pwd]')";

    if (mysqli_query($db, $sql))
    {
        
    }
    else
    {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);

?>

<!DOCTYPE html>
<html>

<head>

<link rel="stylesheet" href="styles.css">
    <title>  Register completed </title>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
</head>

<body>
    <div id="login">
        <h1>Account created succesfully!!</h1>
        <h2> </br> <a href=/temperatureControl/index.php> Home </a> </h2>
    </div>
</body>

</html>