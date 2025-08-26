<?php
    require_once __DIR__ . '/classes/user.php';
    require_once './includes/header.php';
    session_start();

    if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
        header('location: ./index.php');
        exit;
    } 
    
    if(isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        $user = new User()->getUserByName($username);
        if($user) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('location: ./index.php');
            } 
        }
    }
?>
<!-- login -->
<section class="login">
    <form class="login-form" action="" method="POST">
        <h4 class="login-form-title">Login</h4>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" autocomplete="off"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" class="btn login-btn" value="Login">
    </form> 
</section>
<!-- end of login -->