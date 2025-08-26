<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/article.php';

    // handle GET request
    // get ID from selected article
    if($_SERVER['REQUEST_METHOD'] === 'GET') 
        echo json_encode(new Article()->getArticleById($_GET['article-id'])); // JSON response (returns {})
?>