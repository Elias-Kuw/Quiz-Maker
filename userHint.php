<?php
    require('connection.php');

    $user = $_GET["user"];

    $hint ="";
    try {
        $name = $db->prepare("SELECT Username FROM users WHERE Username = :username");
        $name->bindParam(":username", $user);
        $name->execute();
        
        if($name->rowCount() > 0){
            $hint = "This username is not available";
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    
    echo $hint;


?>