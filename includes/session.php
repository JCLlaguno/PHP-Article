<?php
    session_start();
    if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
        header('location: ./index.php');
        exit;
    } 
?>
