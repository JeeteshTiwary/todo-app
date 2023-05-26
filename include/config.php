<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . basename(dirname(__DIR__)) . '/');
session_start();

class Connection
{
    private $connection = null;
    function __construct()
    {
        try {
            $this->connection = new mysqli('localhost', 'root', '', 'todo-app');
        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

}











// $employee = new Employee();

// $employee->check_existence('projects', ['name'=>'todo', 'employee_id'=>2]);

?>