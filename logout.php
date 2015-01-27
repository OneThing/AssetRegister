<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['login_id']);
unset($_SESSION['login_attempts']);
header('Location: login.php');
?>