<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Projectstyle.css">
    <title>LogIn</title>
</head>
<body>
    <?php
        require("header.php");
    ?>
    
    <hr>
    <main>
        <div class="logInBox">
            <h3>Login</h3>
            <form action="Checklogin.php" method="post">
                <input class="tbox" type="text" name="username" placeholder="Username">
                <input class="tbox" type="password" name="password" id="" placeholder="Password">
                <input class="Loginsb" type="submit" name="login" value="Login"> 
            </form>
        </div>
    </main>

    <?php
    require("footer.php");
    ?>
</body>
</html>