<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "User not logged in!"]);
        exit;
    };
    require_once __DIR__ . '/classes/user.php';
    $data = new User()->getAllUsers(); // []

    // convert [] to JSON {}
    echo json_encode($data); // {} 
?>