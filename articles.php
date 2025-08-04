<!-- ARTICLES section -->
<section class="articles">
    <!-- DELETE modal -->
    <?php 
        require_once './app/article.php'; 
        require_once './app/user.php';
        require_once './includes/createForm.php';
        require_once './includes/viewArticleForm.php';
        require_once './includes/updateForm.php';
        require_once './includes/deleteForm.php'; 
    ?>
    <!-- articles container -->
    <div class="section-container">
        <!-- section header -->
        <div class="section-header">
            <span><img class="section-icon" src="./img/articles.svg" alt="users"></span>
            <p class="section-title">Articles</p>
        </div>
        <!-- end of section header -->
        <!-- add article -->
        <div class="new-btn-container">
            <a class="btn bg-blue new-article-btn">New Article</a>
        </div>
        <!-- end of add article -->

        <?php 
            // Articles PAGINATION 
            // get current page no.
            if(isset($_GET['page_no'])) {
                $page_no = $_GET['page_no'];
            } else {
                $page_no = 1;
            }

            // set total records per page value
            $total_records_per_page = 8;

            // calculate offset value & set other variables
            $offset = ($page_no - 1) * $total_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $adjacents = "2";


            // get the total no. of pages for pagination
            $total_articles = new Article()->countTotalArticles();
            $total_articles = $total_articles['total_count'];
            $total_no_of_pages = ceil($total_articles / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; // total pages minus 1

            // get paginated articles
            $articles = new Article()->paginateArticles($total_records_per_page, $offset);

        ?>

        <!-- data table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Posted by</th>
                    <th>Title</th>
                    <!-- <th>Content</th> -->
                    <th class="action-title">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($articles as $article) { ?>
                    <tr>
                        <td data-title="Id"><?php echo $article['id']; ?></td>
                        <td data-title="Posted by">
                            <?php
                                $createdBy = new User()->getUserById($article['userid']);
                                echo $createdBy['username'];
                            ?>
                        </td>
                        <td class="table-article-title" data-title="Title">
                            <p><?php echo $article['article_title']; ?></p>
                        </td>
                        <td data-title="Action">
                            <div class="action-container">
                                <a class="btn bg-black action-view-btn" data-id="<?php echo $article['id']; ?>"><img src="./img/view.svg" alt="Edit"></a>
                                <a class="btn bg-green action-update-btn" data-id="<?php echo $article['id']; ?>" alt="Update"><img src="./img/edit.svg" alt="Edit"></a>
                                <a class="btn bg-red action-delete-btn" data-id="<?php echo $article['id']; ?>" alt="Delete"><img src="./img/delete.svg" alt="Delete" ></a>

                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- end of data table -->
        
         <!-- pagination-pages -->
        <div class="pagination-pages">
            <p>Page <?php echo $page_no." of ".$total_no_of_pages; ?></p>
        </div>
        <!-- end of pages -->

        <!-- PAGINATION buttons -->
        <ul class="pagination">
            <!-- PREVIOUS button -->
            <li>
                <a class="btn pagination-btn <?php if ($page_no <= 1) echo 'pagination-btn-disabled'; ?>" 
                <?php if($page_no > 1) echo "href='?page=articles&page_no=$previous_page'"; ?>>Previous</a>
            </li>

            <!-- clickable PAGE buttons -->
            <?php
                if ($total_no_of_pages <= 10) {  	 
                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                        if ($counter == $page_no) {
                            echo "<li><a class='btn pagination-btn pagination-btn-active'>$counter</a></li>";	
                        } else {
                            echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$counter'>$counter</a></li>";
                        }
                    }
                } else if ($total_no_of_pages > 10) {
                    
                    // Here we will add further conditions

                    if($page_no <= 4) {	

                        for ($counter = 1; $counter < 8; $counter++){	

                            if ($counter == $page_no) {
                                echo "<li><a class='btn pagination-btn pagination-btn-active'>$counter</a></li>";	
                            } else {
                                echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$counter'>$counter</a></li>";
                            }

                        }

                        echo "<li><a class='btn pagination-btn'>...</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$second_last'>$second_last</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";

                    } else if ($page_no > 4 && $page_no < $total_no_of_pages - 4) {		

                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=1'>1</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=2'>2</a></li>";
                        echo "<li><a class='btn pagination-btn'>...</a></li>";

                        for (
                            $counter = $page_no - $adjacents;
                            $counter <= $page_no + $adjacents;
                            $counter++
                            ) {		
                            if ($counter == $page_no) {
                                echo "<li><a class='btn pagination-btn pagination-btn-active'>$counter</a></li>";	
                            } else {
                                echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$counter'>$counter</a></li>";
                            }                  
                        }

                        echo "<li><a class='btn pagination-btn'>...</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$second_last'>$second_last</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";

                    } else {

                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=1'>1</a></li>";
                        echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=2'>2</a></li>";
                        echo "<li><a class='btn pagination-btn'>...</a></li>";

                        for (
                            $counter = $total_no_of_pages - 6;
                            $counter <= $total_no_of_pages;
                            $counter++
                        ) {
                            if ($counter == $page_no) {
                                echo "<li><a class='btn pagination-btn pagination-btn-active'>$counter</a></li>";	
                            } else {
                                echo "<li><a class='btn pagination-btn' href='?page=articles&page_no=$counter'>$counter</a></li>";
                            }                   
                        }
                    }
                }
            ?>

            <!-- NEXT button -->
            <li >
                <a class="btn pagination-btn <?php if ($page_no >= $total_no_of_pages) echo 'pagination-btn-disabled'?>"
                <?php if($page_no < $total_no_of_pages) echo "href='?page=articles&page_no=$next_page'"; ?>>Next</a>
            </li>
        </ul>
        <!-- end of PAGINATION buttons -->
    </div>
    <!-- end of articles container -->
</section>
<!-- end of ARTICLES section -->