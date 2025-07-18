<?php
    require_once './app/user.php';
    require_once './includes/header.php';

    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();
        $user->createUser($username, $password_hash);
        header('location: ./index.php');
    }
?>
    <form class="add-user" action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value=""><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" value=""><br><br>
        <input type="submit" name="submit" value="submit">
    </form> 

<?php require_once('./includes/footer.php'); ?>