<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/article.php';
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);

    // validate JSON
    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

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
            $userid = $_SESSION['userid'];

            $result = new Article()->createArticle($userid, $article_title, $article_content);

            if($result) echo json_encode(["success" => true, "message" => "Added new article!"]);

        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            
        }
    }
?>