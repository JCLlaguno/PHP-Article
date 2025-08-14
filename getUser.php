<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "User not logged in!"]);
        exit;
    };
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    // if POST request
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get user ID from loaded user (fetch())
        $id = $input['userid'];

    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        /*  
            if GET request
            get user ID from session
            (logged in/active user)
        */
        $id = $_SESSION['userid'];
    } 
    echo json_encode(new User()->getUserById($id)); // JSON response
?>