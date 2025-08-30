<!-- USERS section -->
<section class="users 
<?php 
    if($_SESSION['username'] !== 'JC@admin') echo 'page-hidden'; 
?>">
    <?php 
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
            <a class="btn bg-blue new-btn">New User</a>
        </div>
        <!-- end of add user -->
        <!-- DATA TABLE -->
        <div class="table-container">
            <!-- article lists header container -->
            <div class="table-header-container">
                <!-- table header -->
                <p class="table-header-title">Users</p>
                <!-- end of table header -->
            </div>
            <!-- end of article lists header container -->
            <!-- mobile scroll wrapper -->
            <div class="table-scroll">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Photo</th>
                            <th>Username</th>
                            <th class="action-title">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- USER DATA -->
                    </tbody>
                </table>
            </div>
            <!-- end of mobile scroll wrapper -->
        </div>
        <!-- end of DATA TABLE -->
    </div>
    <!-- end of users container -->
</section>
<!-- end of USERS section -->
