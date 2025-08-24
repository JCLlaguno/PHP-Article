<?php 
    require_once __DIR__ . '/classes/user.php';
    require_once __DIR__ . '/classes/article.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        // delete user photo
        // find user by ID
        $foundUser = new User()->getUserById($input['delete-id']);
        // set up local upload directory path
        $uploadDir = __DIR__ . "/uploads/";
        
        // get old photo url from db
        $photoUrl = $foundUser['photo']; // complete url from db
        $oldFileName = basename($photoUrl); // extract filename from url
        $oldImg = $uploadDir . $oldFileName; // append db filename to local upload dir
        if(file_exists($oldImg)) unlink($oldImg); // DELETE old photo locally

        // delete user from DB
        new User()->deleteUser($input['delete-id']); 
        
        // delete articles of user
        new Article()->deleteArticleByUser($input['delete-id']);   
        
        echo json_encode(["success" => true, "message" => "User was deleted!"]);  
    }  
?>
