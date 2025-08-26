<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/article.php';

    // handle GET request
    // get ID from selected article
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // get ARTICLE ID from fetch()
        $id = $_GET['article-id'];
        // check if an article exists in db
        $data = new Article()->getArticleById($id); // []

        // convert [] to JSON {}
        echo json_encode($data); // {}
    }
?>