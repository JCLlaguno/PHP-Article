<?php 
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/article.php';
    header('Content-Type: application/json; charset=utf-8');
        $input = json_decode(file_get_contents('php://input'), true);

        // set delete ID
        $deleteId = $input['delete-id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && !empty($deleteId)) {

        $result = new Article()->deleteArticle($deleteId);   
        
        if($result) echo json_encode(["success" => true, "message" => "Article was deleted!"]);  
    } 
?>