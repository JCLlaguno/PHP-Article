<!-- navbar -->
<nav class="navbar">
    <!-- nav header -->
    <div class="nav-header">
        <!-- nav left -->
        <div class="nav-left">
            <!-- nav logo -->
            <div class="nav-logo-container">
                <a class="nav-logo" href="./index.php">
                    <img src="./img/articles.svg" alt="">
                    <h3 class="nav-title">Articles</h3>
                </a>
            </div>
            <!-- end of nav logo -->
            <!-- nav menu toggle -->
            <div class="mobile-toggle-btn">
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
            </div>
            <!-- end of nav menu toggle -->
        </div>
        <!-- end of nav left -->

        <!-- nav right -->
        <div class="nav-right">
            <?php if(isset($_SESSION['userid'])) { ?>
                <!-- nav user photo -->
                <div class="nav-user-photo-container">
                    <img class="nav-user-photo" alt="user photo">
                </div>
                <!-- end of nav user photo -->
                <!-- nav logout button -->
                <a href="./logout.php" class="nav-logout-btn">Log Out</a>
                <!-- end of nav logout button -->
            <?php } ?>
        </div>
        <!-- end of nav right -->

    </div>
    <!-- end of nav header -->
</nav>
<!-- end of navbar -->