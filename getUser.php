<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json; charset=utf-8');

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