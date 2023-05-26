<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Employee.php';


$employeeObj = new Employee();
$id = $_GET['id'];
$employeeObj->do_delete($id);
?>


