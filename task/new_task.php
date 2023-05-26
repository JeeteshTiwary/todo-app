<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/config.php';

if ($_POST) {
    $check = '';
    $employee_id = 0;
    $name = $_POST['name'];
    $due_date = $_POST['due_date'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $project = $_POST['project'];
    $employee_id = $_SESSION['employee']['id'];
    $task = new Task();
    $taskExists = $task->check_existence('tasks', ['name' => $name, 'employee_id' => $employee_id, 'project_id' => $project]);
    if (!$taskExists) {
        $task->create('tasks', ['name', 'due_date', 'description', 'status', 'project_id', 'employee_id'], [$name, $due_date, $description, $status, $project, $employee_id]);
        $check = "Task \"{$name}\" has been created.";
        header('location:index.php?page=new_task&success=' . $check);
        exit;
    } else {
        $check = "Task \"{$name}\" already exists.";
        header('location:index.php?page=new_task&error=' . $check);
        exit;
    }
}
?>

<div class="container">
    <div class="jumbotron">
        <h2 class="display-4 mx-3">Add New Task </h2>
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
                <label for="name">Name<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="task name here.." required>
            </div>
            <div class="form-group col-md-6">
                <label for="due_date">due_date<span style="color:red;">*</span></label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" cols="5" required> </textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="status">Status<span style="color:red;">*</span></label>
                <select class=" form-control" id="status" name="status" required>
                    <option value="">select status</option>
                    <option value="0">Pending</option>
                    <option value="1">In-progress</option>
                    <option value="2">Complete</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="project">Project<span style="color:red;">*</span></label>
                <select class="form-control" id="project" name="project">
                    <?php
                    $task = new Task();
                    $records = $task->get_records('projects', 'id, name');
                    foreach ($records as $record) {
                        echo '<option value="' . $record['id'] . '">' . $record['name'] . '</option>';
                    }
                    ?>
                </select>
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
                    <a class="btn btn-outline-primary" href="index.php?page=dashboard"> Back </a>
                </div>
            </div>
        </form>
    </div>
</div>