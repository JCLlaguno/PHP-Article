<?php
    session_start();
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    
    if(!isset($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "User not logged in!"]);
        exit;
    };
    if (!isset($_GET['userid']) || empty($_GET['userid'])) {
        /*  
            if no userid on get request,
            get user ID from session (logged in/active user)
        */
        $id = $_SESSION['userid'];
    } else {
        // get user ID from fetched user (GET request)
        $id = $_GET['userid'];
    }
    echo json_encode(new User()->getUserById($id)); // JSON response
?>