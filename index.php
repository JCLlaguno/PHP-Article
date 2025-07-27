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

        // Select the ACTIVE page
        // DEFAULT page
        if(!isset($_GET['page'])) $_GET['page'] = 'users';
        
        // if page = articles
        if ($_GET['page'] == 'articles') require_once './articles.php';
        // if page = users
        else if($_GET['page'] == 'users') require_once './users.php';
     ?>
</main>
<!-- end of MAIN content-->

<!-- FOOTER -->
<?php require_once('./includes/footer.php'); ?>