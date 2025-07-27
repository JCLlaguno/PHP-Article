<?php
    require_once './app/article.php';
    require_once './includes/header.php';

    // get ARTICLE ID from url
    $id = $_GET['id'];
    
    $article_obj = new Article(); // create a new ARTICLE object

    // check if an article exists in db
    $article = $article_obj->getArticleById($id); // returns []

    if(isset($_POST['submit'])) {
        if(!empty($_POST['article-title']) && !empty($_POST['article-content'])) {
            $article_title = trim($_POST['article-title']);
            $article_content = trim($_POST['article-content']);

            $result = $article_obj->updateArticle($id, $article_title, $article_content);
            if($result) header('location: ./index.php?page=articles');
        }
    }
?>
<!-- create article section -->
<section class="create-article-section">
    <div class="section-container">
        <form class="create-article-form custom-form" action="" method="POST">
            <h4 class="form-title">Update Article</h4>
            <label class="form-label" for="article-title">Title:</label>
            <textarea class="article-title" name="article-title" id="article-title"><?php echo $article['article_title']; ?></textarea>
            <label class="form-label" for="article-content">Content</label>
            <textarea class="article-content" name="article-content" id="article-content"><?php echo $article['article_content']; ?></textarea>
            <div class="form-btn-container">
                <a href="./index.php?page=articles" class="btn bg-black form-back-btn">Back</a>
                <input class="btn bg-green form-update-btn" type="submit" name="submit" value="Update Article">
            </div>
        </form> 
    </div>
</section>
<!-- end of create article section -->

<?php require_once './includes/footer.php'; ?>