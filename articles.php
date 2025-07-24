<!-- ARTICLES section -->
<section class="articles">
    <!-- articles container -->
    <div class="section-container">
        <!-- section header -->
        <div class="section-header">
            <span><img class="section-icon" src="./img/articles.svg" alt="users"></span>
            <p class="section-title">Title</p>
        </div>
        <!-- end of section header -->
        <!-- add article -->
        <div class="new-btn-container">
            <a href="./createArticle.php" class="btn new-btn">New Article</a>
        </div>
        <!-- end of add article -->
        <!-- data table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <!-- <th>Content</th> -->
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
                        <td class="table-article-title" data-title="Title">
                            <p><?php echo $article['article_title']; ?></p>
                        </td>
                        <!-- <td class="table-article-content" data-title="Content">
                            <p>
                                <?php 
                                    // $str = $article['article_content'];
                                    // if (strlen($str) > 10) {
                                    // $short_str = substr($str, 0, 100) . '...';
                                    // echo($short_str);
                                    // } else echo $str;
                                ?>
                            </p>
                        </td> -->
                        <td data-title="Action">
                            <div class="action-container">
                                <a class="btn action-view-btn" href="./viewArticle.php?id=<?php echo $article['id']; ?>"><img src="./img/view.svg" alt="Edit"></a>
                                <a class="btn action-update-btn" href="./updateArticle.php?id=<?php echo $article['id']; ?>"><img src="./img/edit.svg" alt="Edit"></a>
                                <a class="btn action-delete-btn" href="#" data-id="<?php echo $article['id']; ?>" alt="Delete"><img src="./img/delete.svg" alt="Delete" ></a>

                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- end of data table -->
        <?php require_once './includes/deleteModal.php' ?>
    </div>
    <!-- end of articles container -->
</section>
<!-- end of ARTICLES section -->