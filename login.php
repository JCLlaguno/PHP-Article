<?php
    require_once __DIR__ . '/classes/user.php';
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        http_response_code(400);
        echo json_encode(['error' => 'Invalid Request Method!']);
        exit;

    }
    
    if(empty($_POST['username']) || empty($_POST['password'])) {

        http_response_code(400);
        echo json_encode(['error' => 'Username or Password is empty!']);
        exit;
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = new User()->getUserByName($username);

    if(!$user) { 

        http_response_code(400);
        echo json_encode(['error' => 'User does not exist!']);
        exit;

    }

    if(!password_verify($password, $user['password'])) {

        http_response_code(400);
        echo json_encode(['error' => 'Invalid Password!']);
        exit;

    }

    if(password_verify($password, $user['password'])) {

        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['success' => true, 'redirect' => './index.php']);
        exit;

    }
?>