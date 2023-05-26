<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Employee.php';


$employeeObj = new Employee();
$employees = $employeeObj->get_records('employees', 'id, name, email, created_at', 'id != 1');
$id = $_GET['id'];

$empRecord = $employeeObj->get_records('employees', 'id, name, email, role', "id = $id");
$empRoles = $employeeObj->fetch_record("SELECT id,name FROM roles");
// var_dump($empRecord); die;

$name = $empRecord[0]['name'];
$email = $empRecord[0]['email'];
$role = $empRecord[0]['role'];

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $employeeObj->do_update($id, $name, $email, $role);
}

?>

<div class="container mt-4">
    <div class="d-flex justify-content-center align-items-center">
        <div class="jumbotron w-50 ">
            <h1>Update Employee Details</h1>
            <hr>
            <form action="" method="post">
                <div class="form-group">
                    <label for="Name">Name<span class="text-danger">*</span></label>
                    <input class="form-control col-sm-9" type="text" name="name" value="<?php echo $name; ?>">
                </div>
                <div class="form-group">
                    <label for="Email">Email<span class="text-danger">*</span></label>
                    <input id="" class="form-control col-sm-9" type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group col-md-9">
                    <label for="Role">Role<span style="color:red;">*</span></label>
                    <select class="custom-select form-control" id="role" name="role" required>
                        <option value="">select role</option>
                        <?php
                        foreach ($empRoles as $empRole) { ?>
                            <option value="<?php echo $empRole['id']; ?>" <?php if ($role == $empRole['id']) {
                                  echo "selected";
                              } ?>> <?php echo $empRole['name']; ?> </option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : 0; ?>">
                    <input type="Submit" name="submit" value="update" class="btn btn-outline-primary col-md-4 mx-3">
                    <a href="index.php?page=display_employee" class="btn btn-outline-warning col-md-4 mx-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>