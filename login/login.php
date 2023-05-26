<?php
if (!empty($_SESSION['employee'])) {
    header('location: Dashboard.php');
}
require_once $_SERVER['DOCUMENT_ROOT'].'/todo-app/include/Authenticate.php';

if ($_POST) {
    $success = "";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $employee = new Model();
    $success = $employee->do_login($email, $password);
    if ($success) {
        header('location:../index.php?page=dashboard');
        exit();
    } else {
        header('location: login.php?message=Invalid Credentials');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Todo App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <div class="jumbotron">
            <?php if (!empty($_GET['message'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $_GET['message'] ?>.
                </div>
            <?php } ?>
            <h1 class="display-4 mx-3">Login Here</h2>
                <hr />
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="form-group ">
                            <label for="Email1">Email <span style="color:red;">*</span> </label>
                            <input type="email" name="email" class="form-control" id="email_id"
                                placeholder="example@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="Password1">Password <span style="color:red;">*</span> </label>
                            <input type="password" name="password" class="form-control" id="user_password_id"
                                placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="row col-md-6 mx-1">
                                <button type="submit" class="btn btn-outline-primary">Login</button>
                            </div>

                        </div>

                    </form>
                </div>
        </div>
    </div>
</body>

</html>