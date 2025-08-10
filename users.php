<!-- USERS section -->
<section class="users 
<?php 
    if($_SESSION['username'] !== 'jc') echo 'page-hidden'; 
?>">
    <?php 
        require_once './includes/createUserForm.php'; 
        require_once './includes/updateUserForm.php';
        require_once './includes/deleteUserForm.php'
    ?>
    <!-- users container -->
    <div class="section-container">
        <!-- section header -->
        <div class="section-header">
            <span><img class="section-icon" src="./img/user.svg" alt="users"></span>
            <p class="section-title">Users</p>
        </div>
        <!-- end of section header -->
        <!-- add user -->
        <div class="new-btn-container">
            <a class="btn bg-blue new-user-btn">New User</a>
        </div>
        <!-- end of add user -->
        <!-- data table -->
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Username</th>
                    <th class="action-title">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- end of data table -->
    </div>
    <!-- end of users container -->
</section>
<!-- end of USERS section -->
