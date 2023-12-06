<?php

require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';;
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $sql = "DELETE FROM newstype Where id=$id";
        $result = mysqli_query($con,$sql);
        if ($result){
            header('location:../newstype/index.php');
        }else{
            die(mysqli_error($con));
        }

    }

?>