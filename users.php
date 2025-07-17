<!-- users section -->
<section class="users">
    <!-- users container -->
    <div class="section-container">
        <!-- section header -->
        <div class="section-header">
            <span><img class="section-icon" src="./img/user.svg" alt="users"></span>
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
                            <a class="update-btn" href="./updateUser.php?id=<?php echo $user['id']; ?>"><img src="./img/edit.svg" alt="Edit"></a>
                            <a class="delete-btn" href="./deleteUser.php?id=<?php echo $user['id']; ?>"><img src="./img/delete.svg" alt="Edit"></a>
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