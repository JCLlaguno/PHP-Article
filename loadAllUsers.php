<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    $data = new User()->getAllUsers(); // []

    // convert [] to JSON {}
    echo json_encode($data); // {} 
?>