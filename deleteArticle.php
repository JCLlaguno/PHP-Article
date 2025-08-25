<?php 
    require_once __DIR__ . '/classes/article.php';
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && !empty($input['delete-id'])) {

        new Article()->deleteArticle(intval($input['delete-id']));   
        
        echo json_encode(["success" => true, "message" => "Article was deleted!"]);  
    } else {
        echo json_encode(["success" => false, "message" => "Article was NOT deleted!"]); 
    }
?>