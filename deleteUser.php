<?php 
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    require_once __DIR__ . '/classes/article.php';
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);

    // set delete ID
    $deleteId = intval($input['delete-id']);
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && !empty($deleteId)) {

        // delete user photo
        // find user by ID
        $foundUser = new User()->getUserById($deleteId);
        // set up local upload directory path
        $uploadDir = __DIR__ . "/uploads/";
        
        // get old photo url from db
        $photoUrl = $foundUser['photo']; // complete url from db
        $oldFileName = basename($photoUrl); // extract filename from url
        $oldImg = $uploadDir . $oldFileName; // append db filename to local upload dir
        if(file_exists($oldImg)) unlink($oldImg); // DELETE old photo locally

        // delete user from DB
        new User()->deleteUser($deleteId); 
        
        // delete articles of user
        new Article()->deleteArticleByUser($deleteId);   
        
        echo json_encode(["success" => true, "message" => "User was deleted!"]);  
    }  
?>
