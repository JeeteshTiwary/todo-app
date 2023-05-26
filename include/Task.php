<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Authenticate.php';
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
class Task extends Model
{
}