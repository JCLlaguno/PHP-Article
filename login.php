<?php
    require_once './session.php';
    require_once './app/user.php';
    require_once './header.php';
    
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
    <h4>Login</h4>
    <form class="add-user" action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" value="submit">
    </form> 
</section>
<!-- end of login -->

<?php require_once './footer.php';?>