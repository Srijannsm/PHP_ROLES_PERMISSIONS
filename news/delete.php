<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';;
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $sql = "DELETE FROM news Where id=$id";
        $result = mysqli_query($con,$sql);
        if ($result){
            header('location:../news/index.php');
        }else{
            die(mysqli_error($con));
        }

    }

?>