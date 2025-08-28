<?php 
    session_start();
    if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
        header('location: ./index.php');
        exit;
    } 
?>
<?php  require_once './includes/header.php'; ?>
<!-- login -->
<section class="login">
    <form class="login-form">
        <h4 class="login-form-title">Login</h4>
        <label for="username">Username:</label><br>
        <input class="form-control" type="text" id="username" name="username" autocomplete="off"><br>
        <label for="password">Password:</label><br>
        <input class="form-control" type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" class="btn login-btn" value="Login">
    </form> 
</section>
<!-- end of login -->