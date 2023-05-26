<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/todo-app/include/config.php';
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
if (!empty($_SESSION['employee'])) {
    session_unset();
    session_destroy();
    header('location: login/login.php');   
}
?>