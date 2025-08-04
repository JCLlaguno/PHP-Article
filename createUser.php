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
   

<?php require_once './includes/footer.php'; ?>