<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    echo json_encode(new User()->getAllUsers()); // JSON response (returns {})
?>