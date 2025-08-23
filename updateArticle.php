<?php

    session_start();
    require_once __DIR__ . '/classes/article.php';
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

    // handle UPDATE request
    if($_SERVER['REQUEST_METHOD'] === 'PUT') {

        if (empty($input['article-title']) || empty($input['article-content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        try {
        
            $article_title = trim($input['article-title']);
            $article_content = trim($input['article-content']);
            $article_id = trim($input['update-article-id']);

            new Article()->updateArticle($article_id, $article_title, $article_content);

            echo json_encode(["success" => true, "message" => "Article updated!"]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        try {
            
            if (isset($input['update-article-id']) && isset($input['status'])) {
                new Article()->updateArticleStatus($input['update-article-id'], $input['status']);
                echo json_encode(["success" => true, "message" => "Article status updated!"]);
            }

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
?>