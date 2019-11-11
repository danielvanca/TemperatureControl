<!DOCTYPE html>
<html>

<head>

<link rel="stylesheet" href="styles.css">
    <title>  Register </title>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
</head>

<body>
        <form action="registerCompleted.php" method="post">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="user"><b>Username: </b></label>
                <input type="text" placeholder="Enter username" name="user" required>
                <br>
                <label for="pwd"><b>Password: </b></label>
                <input type="password" placeholder="Enter password" name="pwd" required>

                <hr>

   
                 <button type="submit" class="buttonRegister">Register</button>
            </div>

            <div class="container signin">
                 <p>Already have an account? <a href="/TemperatureControl/webapp/login.php"> Sign in</a>.</p>
             </div>
        </form> 

</body>

</html>

