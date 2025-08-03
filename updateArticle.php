<?php

    session_start();
    require_once './app/article.php';

    // handle GET request
    // get ID from loaded article
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // get ARTICLE ID from fetch()
        $id = $_GET['get_id'];
        // check if an article exists in db
        new Article()->getArticleById($id); // returns JSON
    }

    // handle UPDATE request
    if($_SERVER['REQUEST_METHOD'] === 'PUT') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

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
    }
?>