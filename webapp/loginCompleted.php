<!DOCTYPE html>
<html>

<head>

<link rel="stylesheet" href="styles.css">
    <title>  Login </title>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
</head>

<body>
    
        <h1>Welcome!</h1>
       
        

        
    </div>
</body>

</html>

<?php  
    session_start();
    require('config.php');

    if (!$db)
    {
    die("Database Connection Failed" . mysqli_error($db));
    }

$select_db = mysqli_select_db($db, 'users');

if (!$select_db)
{
    die("Database Selection Failed" . mysqli_error($db));
}

if (isset($_POST['user']) and isset($_POST['pwd']))
{

$user = $_POST['user'];
$pwd = $_POST['pwd'];

$query = "SELECT * FROM `loginregister` WHERE user='$user' and pwd='$pwd'";
 
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$count = mysqli_num_rows($result);

    if ($count == 1)
    {
    $_SESSION['user'] = $user;
    }
    else
    {
    $fmsg = "Invalid Login Credentials.";
    }
}

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    echo "<p style='color:green;font-size:24px'> Hi " . $user . " !</p> ";
    echo "<p style='color:blue;font-size:24px'> This is your profile! </p>";
    echo "</br></br> <a href='chart.html'>Temperature Readings from Sensors</a>";
    echo "</br></br> <a href='chart2.html'>Temperature Set Points</a>";
    echo "</br></br> <a href='logout.php'>Logout</a>"; 
}
else
{

}


?>






