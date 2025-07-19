<?php
    session_start();
    require_once './app/article.php';
    require_once './includes/header.php';

    if(isset($_POST['submit']) && !empty($_POST['title'] && !empty($_POST['content']))){
        $article_title = trim($_POST['title']);
        $article_content = trim($_POST['content']);
        $userid = $_SESSION['userid'];

        $user = new Article();
        $user->createArticle($userid, $article_title, $article_content);
        header('location: ./index.php?page=articles');
    }
?>
<section class="create-article-section">
    <form class="create-article" action="" method="POST">
        <label for="title">Title:</label>
        <textarea class="title" name="title" id="title"></textarea>
        <label for="content">Content</label>
        <textarea class="content" name="content" id="content"></textarea>
        <input class="create-article-btn" type="submit" name="submit" value="Create Article">
    </form> 
</section>
<?php require_once('./includes/footer.php'); ?>