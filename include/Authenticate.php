<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/todo-app/include/Model.php';

class Authenticate extends Model
{
    function isLoggedIn()
    {
        if (!isset($_SESSION['employee'])) {
            header('location: login/login.php');
        }
    }
    function isAdmin()
    {
        if (isset($_SESSION['employee']) && $_SESSION['employee']['role'] == 0) {
            return true;
        }
    }

    function authenticate()
    {
        if (empty($_POST["name"])) {
            $errMsg = "Error! You didn't enter the Name.";
            echo $errMsg;
        } else {
            $name = $_POST["name"];
        }
        $name = $_POST["Name"];
        if (!preg_match("/^[a-zA-z]*$/", $name)) {
            $ErrMsg = "Only alphabets and whitespace are allowed.";
            echo $ErrMsg;
        } else {
            echo $name;
        }
        $mobileno = $_POST["phone_number"];
        if (!preg_match("/^[0-9]*$/", $mobileno)) {
            $ErrMsg = "Only numeric value is allowed.";
            echo $ErrMsg;
        } else {
            echo $mobileno;
        }
        $email = $_POST["Email"];
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        if (!preg_match($pattern, $email)) {
            $ErrMsg = "Email is not valid.";
            echo $ErrMsg;
        } else {
            echo "Your valid email address is: " . $email;
        }
        $mobileno = strlen($_POST["phone_number"]);
        $length = strlen($mobileno);

        if ($length < 10 && $length > 10) {
            $ErrMsg = "Mobile must have 10 digits.";
            echo $ErrMsg;
        } else {
            echo "Your Mobile number is: " . $mobileno;
        }
    }
}