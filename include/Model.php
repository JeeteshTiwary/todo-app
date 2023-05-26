<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/config.php';
class Model
{
    public $response = 0;
    private $connection;
    public $records = [];

    function __construct()
    {
        $conn = new Connection;
        $this->connection = $conn->getConnection();
    }

    function create($tableName, $columns, $values)
    {
        try {
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
            if (is_array($values)) {
                $values = '"' . implode('", "', $values) . '"';
            }
            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            // var_dump($sql); die;
            $result = $this->connection->query($sql);
            // var_dump($result);die;
            if ($result) {
                $this->response = $this->connection->insert_id;
                return $this->response;
            }
        } catch (\Throwable $th) {
            $th->getMessage();
        }
        return $this->response;
    }


    function get_records($tableName, $columns, $where = null)
    {
        $response = [];
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        $sql = "SELECT $columns FROM $tableName";
        if ($where) {
            $sql .= " WHERE $where";
        }
        try {
            $result = $this->connection->query($sql);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $response[] = $row;
                }
            }
        } catch (\Throwable $th) {
            $response = [];

        }
        return $response;
    }

    function fetch_record($sql)
    {
        $response = null;
        try {
            $result = $this->connection->query($sql);
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
            // var_dump($response);die;
            return $response;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
    function do_login($email, $password)
    {
        $sql = "SELECT employees.id,employees.name,email,roles.name as role,password FROM employees join roles on employees.role = roles.id WHERE email='$email'";
        try {
            $result = $this->connection->query($sql);
            $employee = $result->fetch_assoc();
            if ($employee && password_verify($password, $employee['password'])) {
                unset($employee['password']);
                $_SESSION['employee'] = $employee;
                return true;
            }
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
        return false;
    }
    function check_existence($tableName, $columns)
    {
        $length = count($columns);
        $i = 0;
        $cols = implode(', ', array_keys($columns));
        $sql = "SELECT $cols FROM $tableName WHERE ";
        foreach ($columns as $column => $value) {
            if (end($columns) == $value) {
                $sql .= "$column='$value'";
            } else {
                $sql .= "$column='$value' And ";
            }
        }
        $existence = 0;
        // var_dump($sql);die;
        try {
            $result = $this->connection->query($sql);
            // var_dump($result); die;
            $existence = $result->num_rows;
            // return $existence;
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
        return $existence;
    }

    function do_delete($id)
    {
        $response = 0;
        $sql = "DELETE FROM employees WHERE id ='$id'";
        try {
            $this->connection->query($sql);
            $response = $this->connection->affected_rows;
            header('location: index.php?page=display_employee&message=User has been Deleted successfully!');
        } catch (Exception $th) {
            die($th->getMessage());
        }
        return $response;
    }

    function do_update($id, $name, $email, $role)
    {
        $response = 0;
        $sql = " UPDATE employees SET name='$name', email='$email', role='$role' where id=$id";
        try {
            $this->connection->query($sql);
            $response = $this->connection->affected_rows;
            // var_dump($response); die;
            $response ? header('location: index.php?page=display_employee&message=Record has been updated successfully! ') : header('location:index.php?page=display_employee&error=No any record has been updated');
        } catch (Exception $th) {
            die($th->getMessage());
        }
        return $response;
    }

    /*
    function get_role($role_id){
        $sql = "SELECT name FROM roles WHERE id = $role_id";
        try {
            $result = $this->connection->query($sql);
            return $result->fetch_assoc();           
        } catch (Exception $th) {
            die($th->getMessage());
        }
       
    } */

}
?>