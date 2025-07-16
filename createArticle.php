<?php
    session_start();
    require_once './app/article.php';
    require_once './header.php';

    if(isset($_POST['submit'])){
        $article_title = trim($_POST['title']);
        $article_content = trim($_POST['content']);
        $userid = $_SESSION['userid'];

        $user = new Article();
        $user->createArticle($userid, $article_title, $article_content);
        header('location: ./index.php');
    }
?>
    <form class="add-user" action="" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="content">Content</label><br>
        <textarea name="content" id="content"></textarea>
        <input type="submit" name="submit" value="submit">
    </form> 

<?php require_once('./footer.php'); ?>