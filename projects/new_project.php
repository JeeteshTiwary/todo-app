<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Project.php';
$projectObj = new Project();
// var_dump($_SESSION['employee']); die;
$role = $_SESSION['employee']['role'];
$employee_id = $_SESSION['employee']['id'];
$projects = $projectObj->fetch_record("SELECT projects.id,title FROM projects join projects_employees on empProject WHERE empProject.employee_id = '$employee_id' ");
// var_dump($projects);die;
$tlRecords = null;
switch ($role) {
    case 'Admin':
        $tlRecords = $projectObj->fetch_record("SELECT id,name FROM employees WHERE role =2");
        break;
    case 'Project Manager':
        $tlRecords = $projectObj->fetch_record("SELECT id,name FROM employees WHERE role =3");
        break;
    case 'Team Leader':
        $tlRecords = $projectObj->fetch_record("SELECT id,name FROM employees WHERE role =4");
        break;
    default:
        // header("location:index.php?page=dashboard");
        die("You don't have access of this page!!");
}

if ($_POST) {
    $check = '';
    $title = $_POST['title'];
    $url = $_POST['url'];
    $tl = $_POST['tl'];
    $employee_id = $_SESSION['employee']['id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if ($end_date > $start_date) {
        $project = new Project();
        $project->new_project();
    } else {
        $check = "Please select a valid date.";
        header('location:index.php?page=new_project&error=' . $check);
        exit;
    }
}
?>

<div class="container">
    <div class="jumbotron">

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
        <form name="newProject" action="" method="post" autocomplete="off">
            <div class="form-group col-md-6">
                <?php if ($role == 'Admin') { ?>
                    <h2 class="display-4 mx-3">Add New Project </h2>
                    <hr>
                    <label for="title">Title<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="project title here.."
                        required>
                </div>

                <div class="form-group col-md-6">
                    <label for="url">Url</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="url here..">
                </div>
                <div class="form-group col-md-6">
                    <label for="tl">
                        <?php
                        echo "Project Manager";
                        ?>
                        <span style="color:red;">*</span>
                    </label>
                    <select class=" form-control" id="tl" name="tl" required>
                        <option value="">select name</option>
                        <?php
                        if ($tlRecords) {
                            foreach ($tlRecords as $empRole) { ?>
                                <option value="<?php echo $empRole['id']; ?>">
                                    <?php echo $empRole['name']; ?> </option>
                            <?php }
                        } else { ?>
                            <option value="">
                                <?php echo "currently there is no any record"; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="start_date">start_date<span style="color:red;">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="end_date">end_date<span style="color:red;">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="form-group form-check mx-3">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-outline-primary mx-3">Add Project</button>
                    </div>
                    <div class="col">
                        <a class="btn btn-outline-primary" href="index.php?page=dashboard"> Back </a>
                    </div>
                </div>
                <div class="form-group col-md-6">
                <?php } else { ?>
                    <h2 class="display-4 mx-3">Assign Project </h2>
                    <hr>
                    <label for="title">Project<span style="color:red;">*</span></label>
                    <select class=" form-control" id="title" name="title" required>
                        <option value="">select project</option>
                        <?php
                        if ($projects) {
                            foreach ($projects as $project) { ?>
                                <option value="<?php echo $project['id']; ?>">
                                    <?php echo $project['title']; ?> </option>
                            <?php }
                        } else { ?>
                            <option value="">
                                <?php echo "currently there is no any record"; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="tl">
                        <?php
                        switch ($role) {
                            case 1:
                                echo "Project Manager";
                                break;
                            case 2:
                                echo "Team Leader";
                                break;
                            case 3:
                                echo "Developer";
                                break;
                            default:
                                die("Access Denied!!");
                            // exit;
                        }
                        ?>
                        <span style="color:red;">*</span>
                    </label>
                    <select class=" form-control" id="tl" name="tl" required>
                        <option value="">select name</option>
                        <?php
                        if ($tlRecords) {
                            foreach ($tlRecords as $empRole) { ?>
                                <option value="<?php echo $empRole['id']; ?>">
                                    <?php echo $empRole['name']; ?> </option>
                            <?php }
                        } else { ?>
                            <option value="">
                                <?php echo "currently there is no any record"; ?>
                            </option>
                            <?php
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
                        <button type="submit" class="btn btn-outline-primary mx-3">Assign Project</button>
                    </div>
                    <div class="col">
                        <a class="btn btn-outline-primary" href="index.php?page=dashboard"> Back </a>
                    </div>
                </div>
            <?php } ?>

        </form>
    </div>
</div>