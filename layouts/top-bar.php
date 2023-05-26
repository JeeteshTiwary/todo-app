<?php 
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/config.php'; 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Todo App </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php?page=dashboard">Dashboard<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Projects
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="btn" href="index.php?page=new_project">New Project</a></li>
                        <li><a class="btn" href="index.php?page=my_projects">My Projects</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Tasks
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="btn" href="index.php?page=new_task">New Task</a></li>
                        <li><a class="btn" href="index.php?page=my_tasks">My Tasks</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Employees
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="btn" href="index.php?page=new_employee">New Employee</a></li>
                        <li><a class="btn" href="index.php?page=display_employee">Show Employees</a></li>
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item active">
                <a class="nav-link" href="index.php?page=new_task">Add Task <span class="sr-only">(current)</span></a>
            </li> -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php?page=daily_todos">Daily Todo <span
                        class="sr-only">(current)</span></a>
            </li>
        </ul>
            <button class="btn btn-primary " disabled>
                <?php
                if ($_SESSION['employee']) {
                    echo "Hi, " . $_SESSION['employee']['name'];
                }
                ?>
            </button>
            <a class="btn btn-outline-secondary my-2 my-sm-0 mx-3" href="index.php?page=logout">Logout</a>
    </div>
</nav>