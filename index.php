<?php
    session_start();
    if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
        header('location: ./login.php');
        exit;
    }
    require_once './app/user.php';
    require_once './app/article.php';

    $users = new User()->getAllUsers();
    $articles = new Article()->getAllArticles();

    // html markup
    require_once './header.php';
    require_once './nav.php';
?>

<!-- main -->
<main class="main">
    <!-- sidebar -->
    <aside class="sidebar">
        <!-- page links -->
        <div class="page-links">
            <a href="./" class="page-link">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./dashboard.svg" alt="dashboard"></span>
                    <h4 class="link-name">Dashboard</h4>
                </div>
            </a>
            <a href="./index.php" class="page-link active">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./user.svg" alt="users"></span>
                    <h4 class="link-name">Users</h4>
                </div>
            </a>
            <a href="./articles.php" class="page-link">
                <div class="page-link-container">
                    <span><img class="link-icon" src="./articles.svg" alt="articles"></span>
                    <h4 class="link-name">Articles</h4>
                </div>
            </a>
        </div>
        <!-- end of page links -->
    </aside>
    <!-- end of sidebar -->
     <!-- users section -->
    <section class="users">
        <!-- users container -->
        <div class="section-container">
            <!-- section header -->
            <div class="section-header">
                <span><img class="section-icon" src="./user.svg" alt="users"></span>
                <p class="section-title">Users</p>
            </div>
            <!-- end of section header -->
            <!-- add user -->
            <div class="add-btn-container">
                <a href="./addUser.php" class="add-btn">Add User</a>
            </div>
            <!-- end of add user -->
            <!-- data table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th class="action-title">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user) { ?>
                    <tr>
                        <td data-title="Id"><?php echo $user['id']; ?></td>
                        <td data-title="Username"><?php echo $user['username']; ?></td>
                        <td data-title="Action">
                            <div class="action-container">
                                <a class="update-btn" href="./updateUser.php?id=<?php echo $user['id']; ?>"><img src="./edit.svg" alt="Edit"></a>
                                <a class="delete-btn" href="./deleteUser.php?id=<?php echo $user['id']; ?>"><img src="./delete.svg" alt="Edit"></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- end of data table -->
        </div>
        <!-- end of users container -->
    </section>
    <!-- end of users section -->
</main>
<!-- end of main -->
    
<?php require_once('./footer.php');