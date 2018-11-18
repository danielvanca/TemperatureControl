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
        <h2> Please enter your username and password!</h2>
        
        <form action="/TemperatureControl/login/temperatureControl/loginCompleted.php" method="post">
            <div class="container">
                <hr>

                <label for="user"><b>Username: </b></label>
                <input type="text" placeholder="Enter username" name="user" required>
                <br>
                <label for="pwd"><b>Password: </b></label>
                <input type="password" placeholder="Enter password" name="pwd" required>

                <hr>

   
                 <button type="submit" class="buttonLogin">Login</button>
            </div>

        </form>

        
    </div>
</body>

</html>