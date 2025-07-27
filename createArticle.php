<?php
    session_start();
    require_once './app/article.php';
    require_once './includes/header.php';

    if(isset($_POST['submit']) && !empty($_POST['article-title'] && !empty($_POST['article-content']))){
        $article_title = trim($_POST['article-title']);
        $article_content = trim($_POST['article-content']);
        $userid = $_SESSION['userid'];

        $article = new Article();
        $article->createArticle($userid, $article_title, $article_content);
        header('location: ./index.php?page=articles');
    }
?>
<!-- create article section -->
<section class="create-article-section">
    <div class="section-container">
        <form class="create-article-form custom-form" action="" method="POST">
            <h4 class="form-title">Create Article</h4>
            <label class="form-label" for="article-title">Title:</label>
            <input class="article-title" name="article-title" id="article-title">
            <label class="form-label" for="article-content">Content</label>
            <!-- <div class="content-editor" id="content-editor" contenteditable></div> -->
            <textarea class="article-content" name="article-content" id="article-content"></textarea>
            <div class="form-btn-container">
                <a href="./index.php?page=articles" class="btn bg-black form-back-btn">Back</a>
                <input class="btn bg-blue form-create-btn" type="submit" name="submit" value="Create Article">
            </div>
        </form> 
    </div>
</section>
<!-- end of create article section -->
<?php require_once './includes/footer.php'; ?>