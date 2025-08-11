<?php
    session_start();
    require_once __DIR__ . '/classes/article.php';

    // handle GET request
    // get ID from loaded article
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // get ARTICLE ID from fetch()
        $id = $_GET['get_id'];
        // check if an article exists in db
        $data = new Article()->getArticleById($id); // []

        // convert [] to JSON {}
        echo json_encode($data); // {}
    }
?>