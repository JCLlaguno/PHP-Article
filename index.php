<?php
    session_start();

    // prevent access to INDEX page if not LOGGED IN
    if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])) {
        header('location: ./loginForm.php');
        exit;
    }

    // include HEADER
    require_once './includes/header.php';

    // set default page to articles
    if(!isset($_GET['page'])) $_GET['page'] = 'dashboard';

    // include dashboard modals 
    if($_GET['page'] === 'dashboard') {
        require_once './includes/viewArticleForm.php';
    }

    // include user modals
    if($_GET['page'] === 'users') {
        require_once './includes/createUserForm.php'; 
        require_once './includes/updateUserForm.php';
        require_once './includes/deleteUserForm.php'; 
    }

    // include article modals
    if($_GET['page'] === 'articles') {
        require_once './includes/createArticleForm.php';
        require_once './includes/viewArticleForm.php';
        require_once './includes/updateArticleForm.php';
        require_once './includes/deleteArticleForm.php'; 
    }
?>

<!-- MAIN content -->
<main class="main">
    <?php
        // include SIDEBAR
        require_once './includes/sidebar.php'; 
    ?>
        <div class="main-container">
            <?php  
                // include NAVBAR
                require_once './includes/nav.php';


                // set ACTIVE page
                switch ($_GET['page']) {
                // if PAGE = users
                case "users":
                    require_once './users.php';
                    break;
                // if PAGE = articles
                case "articles":
                    require_once './articles.php';
                    break;
                //  if PAGE = dashboard (default)
                default:
                    require_once './dashboard.php';
                }
            ?>
        </div>
</main>
<!-- end of MAIN content-->
</body>