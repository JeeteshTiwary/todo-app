<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Project.php';

// $employee_id = $_SESSION['employee']['id'];
// $employee = new Employee();
// $projects = $employee->get_records('projects',['name','url','tl_id','start_date','end_date'],"employee_id=$employee_id");

$projectObj = new Project();
$projects = $projectObj->my_projects();
?>

<div class="container">
    <div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>My Projects </h1>
        <a class="btn btn-outline-success" href="<?php echo BASE_URL; ?>index.php?page=new_project">Add</a>
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
                <th>Url</th>
                <th>Team Leader</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($projects)) { ?>
                <?php foreach ($projects as $project) { ?>
                    <tr>
                        <td>
                            <?php echo $project['name'] ?>
                        </td>
                        <td>
                            <?php echo $project['url'] ?>
                        </td>
                        <td>
                            <?php
                            $emp_id = $project['tl_id'];
                            $tl = $projectObj->get_records("employees", "name", "id=$emp_id");
                            echo $tl[0]['name'];
                            ?>
                        </td>
                        <td>
                            <?php echo $project['start_date'] ?>
                        </td>
                        <td>
                            <?php echo $project['end_date'] ?>
                        </td>

                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td rowspan="4">You don't have any project</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>