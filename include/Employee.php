<?php 
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Model.php';

class Employee extends Model
{
    function employeeData(){
        if ($_GET['page']) {
            $page = $_GET['page'];
            switch ($page) {
                // case 'new_employee':
                //     parent::create($tableName, $columns, $values);
                //     break;
                
                default:

                break;
            }
        }
    }
}

?>