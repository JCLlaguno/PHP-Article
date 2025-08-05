<?php
    session_start();
    require_once './app/user.php';

    // handle POST request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['username']) || empty($input['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        try {
        
            $username = trim($input['username']);
            $password = trim($input['password']);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            new User()->createUser($username, $password_hash);

            echo json_encode(["success" => true, "message" => "Added new user!"]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
?>