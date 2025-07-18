<?php 
    require_once './app/article.php';
    new Article()->deleteArticle($_GET['id']);
    header('location: ./index.php?page=articles');