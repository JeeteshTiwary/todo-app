<?php
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/authenticate.php';

class Project extends Model
{
    function projects()
    {
        if ($_GET['page']) {
            $page = $_GET['page'];
        }
        switch ($page) {
            case 'new_project':
                $authenticate = new Authenticate();
                $this->new_project();
                break;
            case 'my_projects':
                $authenticate = new Authenticate();
                $this->my_projects();

            default:
                echo "Page not found";
                break;
        }
    }

    function new_project()
    {
        $success = null;
        $projectExists = $this->check_existence('projects', ['title' => $_POST['title']]);
        if ($projectExists === 0) {
            if ($_SESSION['employee']['role'] == "Admin") {
                $success = $this->create('projects', ['title', 'url', 'start_date', 'end_date'], [$_POST['title'], $_POST['url'], $_POST['start_date'], $_POST['end_date']]);
                $assign = $_POST['tl'];
                $assigned = $this->create('projects_employees', ['project_id ', 'employee_id '], [$success, $assign]);
            }
            $assign = $_POST['tl'];
            $success = $_POST['title'];
            $assigned = $this->create('projects_employees', ['project_id ', 'employee_id '], [$success, $assign]);
            $empname = $this->fetch_record("SELECT name FROM employees where id ='$assign'");
            if ($assigned) {
                $message = "Project {$_POST['title']} has been created and assigned to {$empname[0]['name']}";
                echo $message;
                header('location:index.php?page=new_project&success=' . $message);
                exit;
            } else {
                $message = "something went wrong.";
                header('location:index.php?page=new_project&error=' . $message);
                exit;
            }
        } else {
            $message = "Project {$_POST['title']} already exists.";
            header('location:index.php?page=new_project&error=' . $message);
            exit;
        }
    }
    function my_projects()
    {
        $employee_id = $_SESSION['employee']['id'];
        $projects = $this->get_records('projects_employees', ['name', 'url', 'tl_id', 'start_date', 'end_date'], "employee_id=$employee_id");
        $sql = "SELECT projects.title,projects.url,projects.start_date,projects.end_date FROM projects_employees join projects on projects_employees.project_id = projects.id join employees on projects_employees.employee_id = employees.id WHERE employees.id =  '$employee_id' ";
        $projects = $this->fetch_record($sql);
        return $projects;
    }

}

?>