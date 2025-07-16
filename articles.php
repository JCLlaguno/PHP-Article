<?php
    session_start();
    if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
        header('location: ./login.php');
        exit;
    }
    require_once './app/user.php';
    require_once './app/article.php';

    $articles = new Article()->getAllArticles();
    $user = new User();

    // html markup
    require_once './header.php';
    require_once './nav.php';
?>

<!-- main -->
<main class="main">
    <!-- sidebar -->
    <aside class="sidebar">
        <!-- page links -->
        <div class="page-links">
            <a href="./" class="page-link">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./dashboard.svg" alt="dashboard"></span>
                    <h4 class="link-name">Dashboard</h4>
                </div>
            </a>
            <a href="./index.php" class="page-link">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./user.svg" alt="users"></span>
                    <h4 class="link-name">Users</h4>
                </div>
            </a>
            <a href="" class="page-link active">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./articles.svg" alt="articles"></span>
                    <h4 class="link-name">Articles</h4>
                </div>
            </a>
        </div>
        <!-- end of page links -->
    </aside>
    <!-- end of sidebar -->
     <!-- articles section -->
    <section class="articles">
        <!-- articles container -->
        <div class="section-container">
            <!-- section header -->
            <div class="section-header">
                <span><img class="section-icon" src="./articles.svg" alt="users"></span>
                <p class="section-title">Title</p>
            </div>
            <!-- end of section header -->
            <!-- add user -->
            <div class="add-btn-container">
                <a href="./createArticle.php" class="add-btn">New Article</a>
            </div>
            <!-- end of add user -->
            <!-- data table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th class="action-title">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $article) { ?>
                    <tr>
                        <td data-title="Id"><?php echo $article['id']; ?></td>
                        <td data-title="Author">
                            <?php
                                $createdBy = $user->getUserById($article['userid']);
                                echo $createdBy['username'];
                            ?>
                        </td>
                        <td class="article-title" data-title="Title">
                            <p><?php echo $article['article_title']; ?></p>
                        </td>
                        <td class="article-content" data-title="Content">
                        <p>
                            <?php 
                                $str = $article['article_content'];
                                if (strlen($str) > 50)
                                $new_str = substr($str, 0, 100) . '...';
                                echo($new_str . "\n");
                            ?>
                        </p>
                        </td>
                        <td data-title="Action">
                            <div class="action-container">
                                <a class="view-btn" href="./viewArticle.php?id=<?php echo $article['id']; ?>"><img src="./view.svg" alt="Edit"></a>
                                <a class="update-btn" href="./deleteArticle.php?id=<?php echo $article['id']; ?>"><img src="./edit.svg" alt="Edit"></a>
                                <a class="delete-btn" href="./deleteArticle.php?id=<?php echo $article['id']; ?>"><img src="./delete.svg" alt="Edit"></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- end of data table -->
        </div>
        <!-- end of users container -->
    </section>
    <!-- end of users section -->
</main>
<!-- end of main -->
    
<?php require_once('./footer.php');