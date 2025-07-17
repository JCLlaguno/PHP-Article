<?php
    session_start();
    // html markup
    require_once './includes/header.php';
    
    // prevent access to index page if not logged in
    if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
        header('location: ./login.php');
        exit;
    }
    require_once './app/user.php';
    require_once './app/article.php';

    $user = new User();
    $users = new User()->getAllUsers();
    $articles = new Article()->getAllArticles();

?>

<!-- main content -->
<main class="main">
     <?php
        require './includes/sidebar.php';

        // select ACTIVE page
        $pages = ['dashboard', 'users', 'articles'];
        in_array($page, $pages) ? require("$page.php") : require("./users.php");
     ?>
</main>
<!-- end of main content-->
    
<?php require_once('./includes/footer.php');