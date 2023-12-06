<?php
   require '../session.php';
   include '../connect.php';
   include '../navbar/navbar.php';
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $sql = "DELETE FROM roles Where id=$id";
        $result = mysqli_query($con,$sql);
        if ($result){
            // echo'success';
             header('location:../role/index.php');
        }else{
            die(mysqli_error($con));
        }

    }

?>