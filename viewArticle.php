<?php
    require_once './app/article.php';
    require_once './includes/header.php';

    // get ARTICLE ID from url
    $id = $_GET['id'];

    // check if an article exists in db
    $article = new Article()->getArticleById($id); // returns []
?>

<!-- view article section -->
<section class="view-article-section">
    <div class="article-container-wrapper">
        <div class="article-container">
            <!-- close article btn-->
            <div class="close-article-btn-container">
                <a href="./index.php?page=articles" class="close-article-btn">
                    <span class="line-1"></span>
                    <span class="line-2"></span>
                    <span class="line-3"></span>
                </a>
            </div>
            <!-- end of close article btn-->
            <!-- view article title -->
            <div class="view-article-title">
                <h4><?php echo $article['article_title'] ?></h4>
            </div>
            <div class="divider"></div>
            <!-- end of view article title -->
            <!-- view article content -->
            <div>
                <pre class="view-article-content"><?php echo $article['article_content']; ?></pre>
            </div>
            <!-- end of view article content -->
        </div>
    </div>
</section>
<!-- end of view article section -->

<?php require_once './includes/footer.php'; ?>