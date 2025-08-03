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
?>