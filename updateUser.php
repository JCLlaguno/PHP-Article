<?php
    require_once './app/user.php';
    require_once './includes/header.php';

    // get USER ID from url
    $id = $_GET['id'];
    
    $user = new User(); // create a new USER object

    // check if user exists in db
    $found_user = $user->getUserById($id); // returns []

    if(isset($_POST['submit'])) {
        if(!empty($_POST['username']) && !empty($_POST['oldpassword']) && !empty($_POST['newpassword'])) {
            $username = trim($_POST['username']);
            $old_password = trim($_POST['oldpassword']);
            $new_password = trim($_POST['newpassword']);
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT); // hash NEW password
       
            // if old pass is NOT equal to inputted old pass
            if(!password_verify($old_password, $found_user['password'])) { // (param: $str, $hash)
                echo 'Old password is incorrect.';

            // if old pass is SAME as new pass
            } else if($old_password === $new_password) {
                echo 'New password must be different.';
            
            // else UPDATE data
            } else {
                $result = $user->updateUser($id, $username, $password_hash);
                if($result) header('location: ./index.php');
            }
        } else echo 'All fields are required.';
    }
?>
    <h4>Update User</h4>
    <form class="add-user" action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $found_user['username']; ?>"><br>
        <label for="password">Old Password:</label><br>
        <input type="password" id="oldpassword" name="oldpassword"><br>
        <label for="new password">New Password:</label><br>
        <input type="password" id="newpassword" name="newpassword"><br><br>
        <input type="submit" name="submit" value="submit">
    </form> 

<?php require_once './includes/footer.php'; ?>