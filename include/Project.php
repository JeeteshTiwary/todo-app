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
            if ($_SESSION['employee']['role'] == 1) {
                $success = $this->create('projects', ['title', 'url', 'start_date', 'end_date'], [$_POST['title'], $_POST['url'], $_POST['start_date'], $_POST['end_date']]);
                $assign = $_POST['tl'];
                $assigned = $this->create('projects_employees', ['project_id ', 'employee_id '], [$success, $assign]);
            }
            $assign = $_POST['tl'];
            $assigned = $this->create('projects_employees', ['project_id ', 'employee_id '], [$success, $assign]);
            // $employeeObj = new Employee();
            $empname = $this->fetch_record("SELECT name FROM employees where id ='$assign'");
            // var_dump($empname);
            if ($assigned) {
                $message = "Project {$_POST['title']} has been created and assigned to $empname[0]['name']";
                header('location:index.php?page=new_project&success=' . $message);
                exit;
            } else {
                header('location:index.php?page=new_project&error=' . $success);
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
        $projects = $this->get_records('projects', ['name', 'url', 'tl_id', 'start_date', 'end_date'], "employee_id=$employee_id");
        return $projects;
    }

}

?>