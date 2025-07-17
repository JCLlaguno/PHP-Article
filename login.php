<?php
    require_once './includes/session.php';
    require_once './app/user.php';
    require_once './includes/header.php';
    
    if(isset($_POST['submit'])) {
        $user = new User();
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        $user = $user->getUserByName($username);
        if($user) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                header('location: ./index.php');
            } else echo 'Incorrect password';
        } else {
            echo 'User does not exist.';
        }
    }
?>
<!-- login -->
<section class="login">
    <form class="login-form" action="" method="POST">
        <h4 class="login-form-title">Login</h4>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" class="login-btn" value="Login">
    </form> 
</section>
<!-- end of login -->

<?php require_once './includes/footer.php';?>