<?php
    session_start();
     try{
        require("connection.php");
        $username=$_POST['username'];
        $password=$_POST['password'];
        $sql="select * from users where Username='$username'";
        $rs=$db->query($sql);



        $db=null;
     }

    catch(DPOException $m){
        die($m->getMessage());
    }

    if($row=$rs->fetch()){
        if(password_verify($password,$row['Password'])){
            $_SESSION['Active']=$username;
            header("location:home.php");
        }
    }
    else{ 
        echo "<script>";
        echo "alert('Wrong username or password');";
        echo"window.location.href = 'login.php';";
        echo"</script>";
    }
    

?>
