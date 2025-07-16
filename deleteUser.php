<?php 
require_once './app/user.php';
new User()->deleteUser($_GET['id']);
header('location: ./index.php');
