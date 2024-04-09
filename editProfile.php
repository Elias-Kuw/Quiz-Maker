<?php
session_start();
require("connection.php");
if(!isset($_SESSION['Active'])){
    echo "login first";
}
else{
    $username = $_SESSION['Active'];
    $msg = "";
    $valid = true;

if (isset($_POST['submit'])) {
    $un = $_POST['username'];
    $eml = $_POST['email'];
    $ps = $_POST['password'];
    $cPs = $_POST['cPassword'];

    if (empty($un) || empty($eml) || empty($ps) || empty($cPs)) {
        $msg = "Please fill all the fields";
        $valid = false;
    } else {
        // Validate username
        if (!preg_match("/^[a-zA-Z0-9]{3,15}$/", $un)) {
            $msg = "Username not valid";
            $valid = false;
        }
        
        // Validate email
        if (!filter_var($eml, FILTER_VALIDATE_EMAIL)) {
            $msg = "Email not valid";
            $valid = false;
        }
        
        // Validate password
        if (!preg_match("/^[A-Za-z0-9\?\&\$\@\.]{8,25}$/", $ps)) {
            $msg = "Password not valid";
            $valid = false;
        }
        
        // Confirm password
        if ($ps !== $cPs) {
            $msg = "Passwords do not match";
            $valid = false;
        }
    }

    if ($valid) {
        try {
            $hPassword = password_hash($ps, PASSWORD_DEFAULT);
            
            $sql = "UPDATE users SET 
            Username = '$un',
            Email = '$eml',
            Password = '$hPassword'
            WHERE Username = '$username';";
            $r = $db->exec($sql);

            if ($r == 1) {
                header("location: logIn.php");
                exit();
            } else {
                $msg = "There was an error while registering";
            }

            $db = null;
        } catch (PDOException $m) {
            die("Error: " . $m->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditProfile</title>
    <script>
        function validateForm() {
            var un = document.getElementById("username").value;
            var eml = document.getElementById("email").value;
            var ps = document.getElementById("password").value;
            var cPs = document.getElementById("cPassword").value;
            
            var errorMsg = "";
            var valid = true;
            
            if (un.trim() === "") {
                errorMsg += "Please enter a username\n";
                valid = false;
            }
            
            if (eml.trim() === "") {
                errorMsg += "Please enter your email\n";
                valid = false;
            }
            
            // Email format validation using regular expression
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailRegex.test(eml)) {
                errorMsg += "Email not valid\n";
                valid = false;
            }
            
            if (ps.trim() === "") {
                errorMsg += "Please enter a password\n";
                valid = false;
            }
            
            if (cPs.trim() === "") {
                errorMsg += "Please confirm your password\n";
                valid = false;
            }
            
            if (ps !== cPs) {
                errorMsg += "Passwords do not match\n";
                valid = false;
            }
            
            if (!valid) {
                alert(errorMsg);
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
<header>
        <a href="home.php"><img class="WLogo" style="width: 100px;height: 100px;" src="image/logo.png" alt="Logo"></a>
        <div class="headert">
        <h2>Welcome, <?php echo isset($_SESSION['Active']) ? $_SESSION['Active'] : ''; ?></h2> 
        <a href="sessionDes.php">Logout</a>
        <a href="firstform.php">Create Quiz</a>
        <a href="editProfile.php">Edit profile</a>
        </div>
    </header>

    <hr>

    <div class="rbox">
        <h1>Register</h1><br>
        
        <?php echo $msg; ?>
        
        <form method="post" onsubmit="return validateForm();">
            <h3>Username:</h3>
            <input class="rinput" type="text" name="username" id="username" placeholder="Enter a username">
            <h3>Email:</h3>
            <input class="rinput" type="email" name="email" id="email" placeholder="example@outlook.com">
            <h3>Password:</h3>
            <input class="rinput" type="password" name="password" id="password" placeholder="Enter a password">
            <h3>Confirm Password:</h3>
            <input class="rinput" type="password" name="cPassword" id="cPassword" placeholder="Confirm your password">

            <input class="rbutton" type="submit" name="submit" value="Change Data">
            <a href="home.php"><input class="rbutton" type="button" value="Cancel"></a>
        </form>
    </div>

    <?php require("footer.php"); ?>
</body>
</html>






<?php
}
?>