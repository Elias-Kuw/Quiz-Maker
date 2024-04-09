<?php
    session_id('Active'); 
    session_start(); 
    session_destroy(); 
    
    header('location:home.php');
?>