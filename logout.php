<?php
    session_start();
    setcookie('username', $_SESSION['login'], time() - 100000, '/');
    setcookie('password', $_SESSION['password'], time() - 100000, '/');
    unset($_SESSION['login']);
    unset($_SESSION['password']);    
    header('location: login.php');
?>

