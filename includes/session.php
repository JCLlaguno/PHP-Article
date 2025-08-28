<?php 
    session_start();

    // prevent access if not LOGGED IN
    if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["error" => "User not logged in!"]);
        header('location: ./loginForm.php');
        exit;
    };
?>