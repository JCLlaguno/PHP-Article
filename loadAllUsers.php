<?php
    require_once './classes/user.php';
        $data = new User()->getAllUsers(); // []

        // convert [] to JSON {}
        echo json_encode($data); // {} ?>