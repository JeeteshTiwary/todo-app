<?php 
if (empty($_SESSION['employee'])) {
    header('location: login/login.php');
}
?>
<center>
<h1 class="Display-4 mt-5 align-content-center"> Welcome to Dashboard </h1>
</center>