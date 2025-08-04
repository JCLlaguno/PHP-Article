<?php
    require_once './app/user.php';
        $data = new User()->getAllUsers(); // []

        // convert [] to JSON {}
        echo json_encode($data); // {} ?>