<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/article.php';
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);

    // handle POST request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty($input['article-title']) || empty($input['article-content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        try {

            $article_title = trim($input['article-title']);
            $article_content = trim($input['article-content']);
            $userid = trim($_SESSION['userid']);

            new Article()->createArticle($userid, $article_title, $article_content);

            echo json_encode(["success" => true, "message" => "Added new article!"]);

        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            
        }
    }
?>