<?php 
    require_once './app/user.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        new User()->deleteUser($input['delete-id']);   
        
        echo json_encode(["success" => true, "message" => "User was deleted!"]);  
    }  
?>
