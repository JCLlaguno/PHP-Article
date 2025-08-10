<?php
    session_start();
    // HEADER
    require_once './includes/header.php';
    
    // prevent access to INDEX page if not LOGGED IN
    if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
        header('location: ./login.php');
        exit;
    }
?>

<!-- MAIN content -->
<main class="main">
     <?php
        // set DEFAULT page
        if(!isset($_GET['page'])) $_GET['page'] = 'articles';

        // include SIDEBAR
        require_once './includes/sidebar.php';

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
</main>
<!-- end of MAIN content-->

<!-- FOOTER -->
<?php require_once './includes/footer.php'; ?>