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
        // header('location: ./index.php?page=articles');
    }
?>
<!-- create article section -->
<section class="create-article-section">
    <div class="section-container">
        <form class="create-article-form custom-form" action="" method="POST">
            <h4 class="form-title">Create Article</h4>
            <label class="form-label" for="article-title">Title:</label>
            <textarea class="article-title" name="article-title" id="article-title"></textarea>
            <label class="form-label" for="article-content">Content</label>


            <!-- <div class="toolbar">
                <button
                    class="tool-items fa fa-underline"
                    onclick="document.execCommand('underline', false, '');"
                ></button>

                <button
                    class="tool-items fa fa-italic"
                    onclick="document.execCommand('italic', false, '');"
                ></button>

                <button
                    class="tool-items fa fa-bold"
                    onclick="document.execCommand('bold', false, '');"
                ></button>

                <button class="tool-items fa fa-link" onclick="link()"></button>

                <button
                    class="tool-items fa fa-scissors"
                    onclick="document.execCommand('cut',false,'')"
                ></button>

                <input
                    class="tool-items fa fa-file-image-o"
                    type="file"
                    accept="image/*"
                    id="file"
                    style="display: none"
                    onchange="getImage()"
                />

                <label for="file" class="tool-items fa fa-file-image-o"></label>

                <button
                    class="tool-items fa fa-undo"
                    onclick="document.execCommand('undo',false,'')"
                ></button>

                <button
                    class="tool-items fa fa-repeat"
                    onclick="document.execCommand('redo',false,'')"
                ></button>

                <button class="tool-items fa fa-tint" onclick="changeColor()"></button>

                <button
                    class="tool-items fa fa-strikethrough"
                    onclick="document.execCommand('strikeThrough',false,'')"
                ></button>

                <button
                    class="tool-items fa fa-trash"
                    onclick="document.execCommand('delete',false,'')"
                ></button>

                <button
                    class="tool-items fa fa-scribd"
                    onclick="document.execCommand('selectAll',false,'')"
                ></button>

                <button class="tool-items fa fa-clone" onclick="copy()"></button> -->

                <!-- Justify -->

                <!-- <button
                    class="tool-items fa fa-align-center"
                    onclick="document.execCommand('justifyCenter',false,'')"
                ></button>

                <button
                    class="tool-items fa fa-align-left"
                    onclick="document.execCommand('justifyLeft',false,'')"
                ></button>
                <button
                    class="tool-items fa fa-align-right"
                    onclick="document.execCommand('justifyRight',false,'')"
                ></button>
            </div> -->

            <div class="center">
                <div class="editor" contenteditable></div>
            </div>



            <input type="hidden" class="article-content" name="article-content" id="article-content">
            <div class="form-btn-container">
                <a href="./index.php?page=articles" class="btn bg-black form-back-btn">Back</a>
                <input class="btn bg-blue form-create-btn" type="submit" name="submit" value="Create Article">
            </div>
        </form> 
    </div>
</section>
<!-- end of create article section -->
<?php require_once('./includes/footer.php'); ?>