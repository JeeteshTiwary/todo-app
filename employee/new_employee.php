<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Employee.php';
if($_SESSION['employee']['role'] == "Admin"){
$employeeObj = new Employee();
$empRoles = $employeeObj->fetch_record("SELECT id,name FROM roles");
$rolename = null;
foreach ($empRoles as $empRole) {
    switch ($empRole['id']) {
        case $empRole['id']:
            $rolename = $empRole['name'];
            break;
    }
}

if ($_POST) {
    $check = '';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $password_confirm = $_POST['cnfpassword'];
    if ($password === $password_confirm) {
        $employee = new Employee();
        $emailExist = $employee->check_existence('employees', ['email' => $email]);
        if ($emailExist === 0) {
            $employee->create('employees', ['name', 'email', 'role', 'password'], [$name, $email, $role, password_hash($password, PASSWORD_DEFAULT)]);

            $check = "{$name} has been added as {$rolename}";
            header('location:index.php?page=new_employee&success=' . $check);
            exit;
        } else {
            $check = "Email already exist, Try with another email address!!";
            header('location:index.php?page=new_employee&error=' . $check);
            exit;
        }
    } else {
        $check = "Passwords do not match, Try again!!";
        header('location:index.php?page=new_employee&error=' . $check);
        exit;
    }
}
?>

<div class="container">
    <div class="jumbotron">
        <h2 class="display-4 mx-3">Add New Employee </h2>
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
        <form name="SignupForm" action="" method="post" autocomplete="on">
            <div class="form-group col-md-6">
                <label for="name">Name<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="your name here.." required>
            </div>
            <div class="form-group col-md-6">
                <label for="Email">Email address<span style="color:red;">*</span></label>
                <input type="email" class="form-control" id="Email" name="email" placeholder="your email here.."
                    required>
            </div>
            <div class="form-group col-md-6">
                <label for="Role">Role<span style="color:red;">*</span></label>
                <select class="custom-select form-control" id="role" name="role" required>
                    <option value="">select role</option>
                    <?php
                    foreach ($empRoles as $empRole) { ?>
                        <option value="<?php echo $empRole['id']; ?>">
                            <?php echo $empRole['name']; ?> </option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="Password">Password<span style="color:red;">*</span></label>
                <input type="password" class="form-control" id="Password" name="password"
                    placeholder="your password here.." required>
            </div>
            <div class="form-group col-md-6">
                <label for="cnfPassword">Confirm Password<span style="color:red;">*</span></label>
                <input type="password" class="form-control" id="cnfPassword" name="cnfpassword"
                    placeholder="confirm the password" required>
                <small> <i>confirm password should be same as the entered password</i> </small>
            </div>
            <div class="form-group form-check mx-3">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary mx-3">Add Employee</button>
                </div>
                <div class="col">
                    <a class="btn btn-outline-primary" href="index.php?page=display_employee"> Back </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php 
}else {
    echo "Access Denied!!";
}