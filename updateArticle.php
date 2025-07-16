<?php
    require_once './app/article.php';
    require_once './header.php';

    // get article id from url
    $id = $_GET['id'];
    
    $article = new Article(); // create a new article obj

    // check if article exists in db
    $article = $article->getArticleById($id); // returns []

    if(isset($_POST['submit'])) {
        if(!empty($_POST['article_title']) && !empty($_POST['article_content'])) {
            $article_title = trim($_POST['article_title']);
            $article_content = trim($_POST['article_content']);

            $result = $user->updateArticle($id, $article_title, $article_content);
            if($result) header('location: ./index.php');
        }
    }
?>
    <h4>Update Article</h4>
    <form class="add-user" action="" method="POST">
        <label for="article_title">Article Title:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $article['article_title']; ?>"><br>
        <label for="article_content">Article Content</label><br>
        <input type="text" id="article_content" name="article_content" value="<?php echo $article['article_content']; ?>"><br>
        <input type="submit" name="submit" value="submit">
    </form> 

<?php require_once('./footer.php'); ?>