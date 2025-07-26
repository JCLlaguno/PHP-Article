<?php
    session_start();
    // HEADER
    require_once './includes/header.php';
    
    // prevent access to INDEX page if not LOGGED IN
    if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
        header('location: ./login.php');
        exit;
    }

    // include MODEL files
    require_once './app/user.php';
    require_once './app/article.php';

    // create new objects
    $user = new User();
    $users = new User()->getAllUsers();
    // $articles = new Article()->getAllArticles();
?>

<!-- MAIN content -->
<main class="main">
     <?php
        // SIDEBAR
        require_once './includes/sidebar.php';

        // select ACTIVE page
        $pages = ['dashboard', 'users', 'articles'];
        // in_array($page, $pages) ? require_once("$page.php") : require_once("./articles.php");
        require_once './articles.php';
     ?>
</main>
<!-- end of MAIN content-->

<!-- FOOTER -->
<?php require_once('./includes/footer.php'); ?>