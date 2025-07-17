<!-- navbar -->
<nav class="navbar">
    <!-- nav header -->
    <div class="nav-header center">
        <!-- nav logo -->
        <div class="nav-logo-container">
            <h2 class='title'>Articles</h2>
        </div>
        <!-- end of nav logo -->
        <!-- nav links -->
        <div class="nav-links">
            <!-- nav menu toggle -->
            <div class="mobile-toggle-btn">
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
            </div>
            <!-- end of nav menu toggle -->
         <!-- nav logout button -->
        <?php 
            if(isset($_SESSION['userid'])) echo '<a href="./logout.php" class="nav-logout-btn">Log Out</a>'; 
        ?>
         <!-- end of nav logout button -->
        </div>
        <!-- end of nav links -->
    </div>
    <!-- end of nav header -->
</nav>
<!-- end of navbar -->