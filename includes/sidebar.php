
<!-- mobile sidebar -->
<aside class="mobile-menu">
    <div class="mobile-modal">
        <!-- nav menu toggle -->
        <div class="mobile-toggle-btn">
            <span class="line-1"></span>
            <span class="line-2"></span>
            <span class="line-3"></span>
        </div>
        <!-- end of nav menu toggle -->
        <!-- mobile links -->
        <ul class="mobile-links">
            <li class="<?php if($_GET['page'] === 'dashboard') echo 'selected' ?>"><a class="mobile-link" href="?page=dashboard">Welcome</a></li>
            <li class="
            <?php 
                if($_GET['page'] === 'users') echo 'selected';
                if($_SESSION['username'] !== 'admin') echo 'page-hidden'; 
            
            ?>"><a class="mobile-link" href="?page=users">Users</a></li>
            <li class="<?php if($_GET['page'] === 'articles') echo 'selected' ?>"><a class="mobile-link" href="?page=articles&page_no=1">Articles</a></li>
        </ul>
        <!-- end of mobile links -->
        <!-- log out button -->
        <div class="log-out-btn">
            <a href="./logout.php">Log Out</a>
        </div>
        <!-- end of log out button -->
    </div>
</aside>
<!-- end of mobile sidebar -->

<!-- sidebar -->
<aside class="sidebar">
    <!-- sidebar logo -->
        <a class="sidebar-logo" href="./index.php">
            <img src="./img/logo.svg" alt="">
            <p class="sidebar-title">Articles</p>
        </a>
    <!-- end of sidebar logo -->
    <!-- page links -->
    <div class="page-links">
        <a href="?page=dashboard" class="page-link <?php if($_GET['page'] === 'dashboard') echo 'selected' ?>">
            <div class="page-link-container">
                <span><img class="link-icon" src="./img/dashboard.svg" alt="dashboard"></span>
                <h4 class="sidebar-link-name">Dashboard</h4>
            </div>
        </a>
        <a href="?page=users" class="page-link 
        <?php 
            if($_GET['page'] === 'users') echo 'selected';
            if($_SESSION['username'] !== 'admin') echo 'page-hidden'; 
        ?>">
            <div class="page-link-container">
                <span><img class="sidebar-link-icon" src="./img/user.svg" alt="users"></span>
                <h4 class="sidebar-link-name">Users</h4>
            </div>
        </a>
        <a href="?page=articles" class="page-link <?php if($_GET['page'] === 'articles') echo 'selected'?>">
            <div class="page-link-container">
                <span><img class="sidebar-link-icon" src="./img/articles.svg" alt="articles"></span>
                <h4 class="sidebar-link-name">Articles</h4>
            </div>
        </a>
    </div>
    <!-- end of page links -->
</aside>
<!-- end of sidebar -->