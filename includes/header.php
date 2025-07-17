<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <link href="./css/global.css" rel="stylesheet">
    <link href="./css/nav.css" rel="stylesheet">
    <link href="./css/articles.css" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet">
    <link href="./css/footer.css" rel="stylesheet">
    <script src="./js/hugerte-dist-1.0.9/hugerte.min.js" referrerpolicy="origin"></script>
    <script defer src="./js/script.js"></script>
</head>
<body>
<?php 
    // set the current page
    $page = (isset($_GET['page'])) ? $_GET['page'] : 'users';
    
    require_once './includes/nav.php'; 
?>