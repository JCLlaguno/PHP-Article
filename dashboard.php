<!-- Dashboard section -->
<section class="dashboard">
    <!-- dashboard container -->
    <div class="section-container">
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
         <!-- filter dropdown -->
          <div id="filter-dropdown">
            <select id="statusSelect">
                <option value="3">All</option>
                <option value="0">Unread</option>
                <option value="1">Read</option>
            </select>
        </div>
         <!-- end of filter dropdown -->
         <div class="article-index-container">
            <!-- article lists header -->
             <div class="article-lists-header-container">
                <p class="article-lists-header">
                    Index of Articles
                </p>
             </div>
            <!-- end of article lists header -->
            <!-- article lists -->
            <ul id="dashboard-article-lists"></ul>
            <!-- end of article lists -->
            <!-- page info -->
            <span id="pageInfo"></span>   
            <!-- end of page info -->
            <!-- pagination buttons -->
            <div id="pagination"></div>
            <!-- end of pagination buttons -->
         </div>
    </div>
    <!-- end of dashboard container -->
</section>
<!-- end of Dashboard section -->
