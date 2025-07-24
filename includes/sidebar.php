
<!-- mobile sidebar -->
<aside class="mobile-menu">
    <!-- nav menu toggle -->
    <div class="mobile-toggle-btn">
        <span class="line-1"></span>
        <span class="line-2"></span>
        <span class="line-3"></span>
    </div>
    <!-- end of nav menu toggle -->
    <!-- mobile links -->
    <ul class="mobile-links">
        <li><a class="mobile-link" href="">Dashboard</a></li>
        <li class="<?php if($page === 'users') echo 'selected' ?>"><a class="mobile-link" href="?page=users">Users</a></li>
        <li class="<?php if($page === 'articles') echo 'selected' ?>"><a class="mobile-link" href="?page=articles">Articles</a></li>
    </ul>
    <!-- end of mobile links -->
    <!-- log out button -->
    <div class="log-out-btn">
        <a href="./logout.php">Log Out</a>
    </div>
    <!-- end of log out button -->
</aside>
<!-- end of mobile sidebar -->

<!-- sidebar -->
<aside class="sidebar">
    <!-- page links -->
    <div class="page-links">
        <a href="./" class="page-link">
            <div class="page-link-container">
                <span><img class="link-icon" src="./img/dashboard.svg" alt="dashboard"></span>
                <h4 class="link-name">Dashboard</h4>
            </div>
        </a>
        <a href="?page=users" class="page-link <?php if($page === 'users') echo 'selected'?>">
            <div class="page-link-container">
                <span><img class="link-icon" src="./img/user.svg" alt="users"></span>
                <h4 class="link-name">Users</h4>
            </div>
        </a>
        <a href="?page=articles" class="page-link <?php if($page === 'articles') echo 'selected'?>">
            <div class="page-link-container">
                <span><img class="link-icon" src="./img/articles.svg" alt="articles"></span>
                <h4 class="link-name">Articles</h4>
            </div>
        </a>
    </div>
    <!-- end of page links -->
</aside>
<!-- end of sidebar -->