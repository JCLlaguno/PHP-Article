<?php
    require_once './app/article.php';
    require_once './includes/header.php';

    // get ARTICLE ID from url
    $id = $_GET['id'];

    $article_obj = new Article(); // create a new ARTICLE object

    // check if an article exists in db
    $article = $article_obj->getArticleById($id); // returns []
?>

<!-- view article section -->
<section class="view-article-section">
    <div class="article-container-wrapper">
        <div class="article-container">
            <!-- view article title -->
            <div class="view-article-title">
                <h4><?php echo $article['article_title'] ?></h4>
            </div>
            <div class="divider"></div>
            <!-- end of view article title -->
            <!-- view article content -->
            <div class="view-article-content">
                <p class="view-article-content"><?php echo $article['article_content']; ?></p>
            </div>
            <!-- end of view article content -->
        </div>
    </div>
</section>
<!-- end of view article section -->

<?php require_once('./includes/footer.php'); ?>