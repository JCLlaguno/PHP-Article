<div class="form-modal-container update-modal">
    <!-- update article form -->
    <form class="update-article-form custom-form">
            <div class="form-title bg-green">
                <p>Update Article</p>
            </div>
        <label class="form-label" for="article-title">Title:</label>
        <textarea class="form-control article-title" name="article-title" id="article-title"></textarea>
        <label class="form-label" for="article-content">Content</label>
        <textarea class="form-control article-content" name="article-content" id="article-content"></textarea>
        <input class="id-input" type="hidden" name="article-id" value="article-id">
        <div class="form-btn-container">
            <a class="btn bg-black form-back-btn">Back</a>
            <input class="btn bg-green form-update-btn" type="submit" name="submit" value="Update Article">
        </div>
    </form> 
    <!-- end of update article form -->
</div>
<!-- end of update article section -->