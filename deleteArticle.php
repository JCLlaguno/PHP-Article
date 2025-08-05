<?php 
    require_once './app/article.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        new Article()->deleteArticle($input['delete-id']);   
        
        echo json_encode(["success" => true, "message" => "Article was deleted!"]);  
    }  
?>