<?php
    session_start();
    $_SESSION['login_user'] = "Guest";
    $_SESSION['username'] = "Guest";
    header('location: index.php');
?>