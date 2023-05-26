<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/config.php';
$page_title = 'Todo App';
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/layouts/header.php';

if ($_SESSION['employee']) {
    if ($_GET) {
        $page = $_GET['page'];
        switch ($page) {
            case 'dashboard':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/dashboard.php';
                break;
            case 'new_project':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/projects/new_project.php';
                break;
            case 'my_projects':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/projects/display_projects.php';
                break;
            case 'new_task':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/task/new_task.php';
                break;
            case 'my_tasks':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/task/display_tasks.php';
                break;
            case 'daily_todos':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/todo/daily_todos.php';
                break;
            case 'new_employee':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/employee/new_employee.php';
                break;
            case 'display_employee':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/employee/display_employee.php';
                break;
            case 'update_employee':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/employee/update_employee.php';
                break;
            case 'delete_employee':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/employee/delete_employee.php';
                break;


            case 'logout':
                require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/login/logout.php';
                break;

            default:
                echo "<h1> Page not found </h1>";
                break;
        }
    }
} else {
    header('Location:/todo-app/login/login.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/layouts/footer.php';

?>
