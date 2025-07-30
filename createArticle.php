<?php
    session_start();
    require_once('./app/article.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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
        $userid = $_SESSION['userid'];

        new Article()->createArticle($userid, $article_title, $article_content);

        echo json_encode(["success" => true, "message" => "Record inserted"]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>