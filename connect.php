<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'project1';

    $con = new mysqli($servername,$username,$password,$dbname);
    if (!$con){
        die(mysqli_error($con));
    }

?>