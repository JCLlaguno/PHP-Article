<!-- ARTICLES section -->
<section class="articles">
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
            <a class="btn bg-blue new-btn">New Article</a>
        </div>
        <!-- end of add article -->

        <!-- DATA TABLE -->
        <div class="table-container">
            <!-- article lists header container -->
            <div class="table-header-container">
                <!-- table header -->
                <p class="table-header-title">Articles</p>
                <!-- end of table header -->
                <!-- status filter dropdown -->
                <div class="status-filter-dropdown">
                    <select class="status-select" id="status-select">
                        <option value="0">Unread</option>
                        <option value="1">Read</option>
                        <option value="2">All</option>
                    </select>
                </div>
                <!-- end of status filter dropdown -->
            </div>
            <!-- end of article lists header container -->
            <!-- mobile scroll wrapper -->
            <div class="table-scroll">
                <!-- data table -->
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="article-title">Title</th>
                            <th class="article-status">Status</th>
                            <th class="article-created">Date Created</th>
                            <th class="action-title">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aricle List... -->
                    </tbody>
                </table>
            </div>
            <!-- end of mobile scroll wrapper -->
        </div>
        <!-- end of DATA TABLE -->
        <!-- page info -->
        <span id="page-info"></span>   
        <!-- end of page info -->
        <!-- pagination buttons -->
        <div class="pagination"></div>
        <!-- end of pagination buttons -->
    </div>
    <!-- end of articles container -->
</section>
<!-- end of ARTICLES section -->