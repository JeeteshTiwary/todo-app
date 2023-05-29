<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Employee.php';


$employeeObj = new Employee();
$sql = "SELECT e.id,e.name,e.email,r.name as role,e.created_at FROM roles r join employees e on e.role=r.id WHERE e.id != 1";
$employees = $employeeObj->fetch_record($sql);
?>

<div class="container">
    <div class="mt-5 d-flex justify-content-between align-items-center">
        <h1>Our Employees are here </h1>
        <a class="btn btn-outline-success" href="index.php?page=new_employee">Add</a>
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
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($employees)) { ?>
                <?php foreach ($employees as $employee) { ?>
                    <tr>
                        <td>
                            <?php echo $employee['name']; ?>
                        </td>
                        <td>
                            <?php echo $employee['email']; ?>
                        </td>
                        <td>
                            <?php
                            echo $employee['role'];
                            ?>
                        </td>
                        <td>
                            <?php echo date('dS F, Y h:s A', strtotime($employee['created_at'])); ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-info"
                                href="index.php?page=update_employee&id=<?php echo $employee['id']; ?>">Update</a>
                            <a class="btn btn-outline-danger"
                                href="index.php?page=delete_employee&id=<?php echo $employee['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td rowspan="5">Currently there is no any employee!</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>