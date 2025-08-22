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

        <!-- DATA TABLE -->
        <div class="table-container">
            <!-- article lists header container -->
            <div class="table-header-container">
                <!-- table header -->
                <p class="table-header">Index of Articles</p>
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
                            <th>Title</th>
                            <th>Status</th>
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
        <span class="pageInfo"></span>   
        <!-- end of page info -->
        <!-- pagination buttons -->
        <div class="pagination"></div>
        <!-- end of pagination buttons -->
    </div>
    <!-- end of dashboard container -->
</section>
<!-- end of Dashboard section -->
