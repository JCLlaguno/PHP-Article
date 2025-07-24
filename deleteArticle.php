<?php 
    require_once './app/article.php';
    
    // if(isset($_POST['submit']))
    // new Article()->deleteArticle($_POST['article-id']);
    // header('location: ./index.php?page=articles');


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    // Access data using the 'name' attribute from HTML
    $id = $_POST['article-id']; 

    // Process the data (e.g., save to database, send email)
    new Article()->deleteArticle($id);       
?>