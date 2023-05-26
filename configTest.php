<?php
    // session_start();
    
    class Employee{
        public $response = 0;
        function get_connection(){
            try {
               return new mysqli('localhost', 'root', '', 'test');

            } catch (\Throwable $th) {
                $th->getMessage();
            }
        }

        function create($tableName,$columns,$values){
            try {
                if(is_array($columns)){
                    $columns = implode(', ', $columns);
                }
                if(is_array($values)){
                    $values = '"' . implode('", "', $values) . '"';
                }
                $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
                $connection = $this->get_connection();
                $result = $connection->query($sql);
                if($result){
                    $this->response = $connection->insert_id;
                    return $this->response;
                }
            } catch (\Throwable $th) {
                $th->getMessage();
            }
            return $this->response;
        }
    }

    $employee = new Employee();
    $success = $employee->create('test',['First_Name','Last_Name'],['John','tugrp']);
    if($success){
        echo "Success";
    }
    else{
        echo "Failed";
    }
?>