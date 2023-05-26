<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Model.php';

if ($_POST) {
    $check = '';
    $project = $_POST['project'];
    $task = $_POST['task'];
    $description = $_POST['description'];
    $estimated_hours = $_POST['estimated_hours'];
    $employee = new Model();
    $success = $employee->create('todos', ['project_id ', 'task_id ', 'description', 'estimated_hours'], [$project, $task, $description, $estimated_hours]);
    if ($success) {
        $check = "Todo has been created.";
        header('location:daily_todos.php?success=' . $check);
        exit;
    } else {
        $check = "Something went wrong.";
        header('location:daily_todos.php?error=' . $check);
        exit;
    }
}
?>

<div class="container">
    <div class="jumbotron">
        <h2 class="display-4 mx-3">Add Todo </h2>
        <hr>
        <?php
        if (!empty($_GET['success'])) { ?>
            <span class="alert alert-success alert-dismissible">
                <?php echo $_GET['success'] ?>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <?php } ?>
        </span>
        <?php if (!empty($_GET['error'])) { ?>
            <span class="alert alert-danger alert-dismissible">
                <?php echo $_GET['error'] ?>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <?php }
        ?>
        </span>
        <form name="newTask" action="" method="post" autocomplete="on">
            <div class="form-group col-md-6">
                <label for="project">Project<span style="color:red;">*</span></label>
                <select class="form-control" id="project" name="project">
                    <?php
                    $employee = new Employee();
                    $employee->get_records('projects', 'id, name');
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="task">Task<span style="color:red;">*</span></label>
                <select class="form-control" id="task" name="task">
                    <?php
                    $employee = new Employee();
                    $employee->get_records('tasks', 'id, name', 'project_id = 1');
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" cols="5" required> </textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="estimated_hours">Estimated Hours<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="estimated_hours" name="estimated_hours"
                    placeholder="estimated hours here.." required>
            </div>
            <div class="form-group form-check mx-3">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary mx-3">Add Task</button>
                </div>
                <div class="col">
                    <a class="btn btn-outline-primary" href=""> Back </a>
                </div>
            </div>
        </form>
    </div>
</div>