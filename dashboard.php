<!-- Dashboard section -->
<section class="dashboard">
    <!-- dashboard container -->
    <div class="section-container dashboard-container">
        <!-- section header -->
        <div class="section-header">
            <p class="section-title dashboard-welcome"></p>
        </div>
        <!-- end of section header -->
        <!-- dashboard reports -->
        <div class="dashboard-reports">
            <!-- single card -->
             <card class="dashboard-card users-card bg-blue">
                 <div class="card-icon-container"><img class="card-icon" src="./img/dashboard-user.svg" alt=""></div>
                 <div class="card-title-container"><p class="card-title">Users</p></div>
                 <div class="card-content-container"><p class="card-content users-card-content"></p></div>
            </card>
            <!-- end of single card -->
            <!-- single card -->
            <card class="dashboard-card articles-card bg-green">
                <div class="card-icon-container"><img class="card-icon" src="./img/dashboard-article.svg" alt=""></div>
                <div class="card-title-container"><p class="card-title">Articles</p></div>
                <div class="card-content-container"><p class="card-content articles-card-content"></p></div>
            </card>
            <!-- end of single card -->
        </div>
        <!-- end of dashboard reports -->

        <div class="article-index-container">
            <!-- article lists header container -->
             <div class="article-lists-header-container">
                <!-- article lists header -->
                <p class="article-lists-header">
                    Index of Articles
                </p>
                <!-- end of article lists header -->
                <!-- filter dropdown -->
                <div id="filter-dropdown">
                    <select id="statusSelect">
                        <option value="0">Unread</option>
                        <option value="1">Read</option>
                        <option value="2">All</option>
                    </select>
                </div>
                <!-- end of filter dropdown -->
             </div>
            <!-- end of article lists header container -->
            <!-- article lists -->
            <div class="table-scroll">
                
            <!-- data table -->
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
            <!-- end of article lists -->
        </div>
            <!-- page info -->
            <span id="pageInfo"></span>   
            <!-- end of page info -->
            <!-- pagination buttons -->
            <div id="pagination"></div>
            <!-- end of pagination buttons -->
    </div>
    <!-- end of dashboard container -->
</section>
<!-- end of Dashboard section -->
