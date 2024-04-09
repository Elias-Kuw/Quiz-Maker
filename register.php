<?php
require('connection.php');

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
            
            $sql = "INSERT INTO users VALUES (null, '$un', '$eml', '$hPassword')";
            $r = $db->exec($sql);

            if ($r == 1) {
                echo "<script>";
                echo "alert('you have registered successfully');";
                echo"window.location.href = 'login.php';";
                echo"</script>";
                //header("location: logIn.php");
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
    <title>Register</title>
</head>
<body>
    <?php require("header.php"); ?>

    <hr>

    <div class="rbox">
        <h1>Register</h1><br>
        
        <?php echo $msg; ?>
        
        <form method="post" onsubmit="return validateForm();">
            <h3>Username:</h3>
            <input class="rinput" type="text" name="username" id="username" placeholder="Enter a username" onkeyup="showHint(this.value)">
            <p id="textHint" style="color:red; font-size:12px; "></p>
            <h3>Email:</h3>
            <input class="rinput" type="email" name="email" id="email" placeholder="example@outlook.com">
            <h3>Password:</h3>
            <input class="rinput" type="password" name="password" id="password" placeholder="Enter a password">
            <h3>Confirm Password:</h3>
            <input class="rinput" type="password" name="cPassword" id="cPassword" placeholder="Confirm your password">

            <input class="rbutton" type="submit" name="submit" value="Register">
            <a href="home.php"><input class="rbutton" type="button" value="Cancel"></a>
        </form>
    </div>

    <?php require("footer.php"); ?>


    <script>
        function validateForm() {
            var un = document.getElementById("username").value;
            var eml = document.getElementById("email").value;
            var ps = document.getElementById("password").value;
            var cPs = document.getElementById("cPassword").value;
            
            var errorMsg = "please check the requirements \n";
            var valid = true;
            
            if (un.trim() === "") {
                errorMsg += "- Please enter a username\n";
                document.getElementById("username").style.border="1px solid red";
                 valid = false;
            }else {
                document.getElementById("username").style.border="1px solid lightgreen"; 
            }

            var usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
            if (!usernameRegex.test(un)) {
                errorMsg += "- username not valid\n";
                document.getElementById("username").style.border="1px solid red";
                valid = false;
            }
            
            if (eml.trim() === "") {
                errorMsg += "- Please enter your email\n";
                document.getElementById("email").style.border="1px solid red";
                valid = false;
            }

            // Email format validation using regular expression
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailRegex.test(eml)) {
                errorMsg += "- Email not valid\n";
                document.getElementById("email").style.border="1px solid red";
                valid = false;
            }else{
                document.getElementById("username").style.border="1px solid lightgreen"; 
            }
            
            if (ps.trim() === "") {
                errorMsg += "- Please enter a password\n";
                document.getElementById("password").style.border="1px solid red";
                valid = false;
            }
            var passRegex = /^[A-Za-z0-9\?\&\$\@\.]{8,25}$/;
            if (!passRegex.test(ps)) {
                errorMsg += "- password not valid\n";
                document.getElementById("password").style.border="1px solid red";
                valid = false;
            }else{
                document.getElementById("username").style.border="1px solid lightgreen"; 
            }
            
            if (cPs.trim() === "") {
                errorMsg += "- Please confirm your password\n";
                document.getElementById("cPassword").style.border="1px solid red";
                valid = false;
            }else{
                document.getElementById("username").style.border="1px solid lightgreen"; 
            }
            
            if (ps !== cPs) {
                errorMsg += "- Passwords do not match\n";
                valid = false;
            }
            
            if (!valid) {
                alert(errorMsg);
                return false;
            }
            
            return true;
        }

        function showHint(str){
            if(str.lenght == 0 ){
                document.getElementById("textHint").innerHTML="";
                return;
            }
            const xhttp = new XMLHttpRequest();
            xhttp.onload = namefunction;
            xhttp.open("GET","userHint.php?user="+str);
            xhttp.send();
        }

         function namefunction(){
             document.getElementById("textHint").innerHTML=this.responseText;
             //document.getElementById("username").style.border="1px solid red";
         }
    </script>
</body>
</html>
