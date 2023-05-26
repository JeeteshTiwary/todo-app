<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Task.php';

$employee_id = $_SESSION['employee']['id'];
$taskObj = new Task();
$tasks = $taskObj->get_records('tasks', ['name', 'due_date', 'description', 'status', 'project_id '], "employee_id=$employee_id");
?>

<div class="container">
    <div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>My Tasks </h1>
        <a class="btn btn-outline-success" href="<?php echo BASE_URL; ?>index.php?page=new_task">Add</a>
    </div>

    <?php if (!empty($_GET['message'])) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Hurray!</strong>
            <span>
                <?php echo $_GET['message'] ?>
            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Project</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tasks)) { ?>
                <?php foreach ($tasks as $task) { ?>
                    <tr>
                        <td>
                            <?php echo $task['name'] ?>
                        </td>
                        <td>
                            <?php echo $task['description'] ?>
                        </td>
                        <td>
                            <?php
                            $status = $task['status'];
                            switch ($status) {
                                case 0:
                                    echo "pending";
                                    break;
                                case 1:
                                    echo "in-progress";
                                    break;
                                case 2:
                                    echo "complete";
                                    break;
                                default:
                                    echo "Something went wrong";
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $task['due_date'] ?>
                        </td>
                        <td>
                            <?php
                            $project_id = $task['project_id'];
                            $project = $taskObj->get_records("Projects", "name", "id=$project_id");
                            echo $project[0]['name'];
                            ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td rowspan="5">Your task list is empty.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>