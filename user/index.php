<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login/index.php');
    exit;
}
?>


<?php
// require '../session.php';
include '../connect.php';
include '../navbar/navbar.php'; ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/custom.css"> -->
    <title>USERS</title>
</head>

<body>
    
<div class="container">

        <div class="main-body">

            <button onclick="window.location.href='../user/create.php'" class="btn btn-primary my-5">Add a User</button>
        </div>
        <div class="container mt-5 d-flex justify-content-center">

        <table class="table table-bordered w-60">
            <thead>
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">Profile Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Password</th>
                    <!-- <th scope="col">Username</th> -->
                    <th scope="col">E-mail</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM users ";
                $result = mysqli_query($con, $sql);
                if ($result) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $image = $row['image'];
                        // echo $image;
                        // die();   
                        $name = $row['name'];
                        $password = $row['password'];
                        $email = $row['email'];
                        // $username = $row['username']; ?>

                        <!-- echo ' -->
                        <tr>
                            <th scope="row"><?= $id ?></th>
                            <td><img src="<?=$image?>" alt="News Picture" width="100" class="image-center"></td>
                            <td><?= $name ?></td>
                            <td><?= $password ?></td>
                            <!-- <td><?= $username ?></td> -->
                            <td><?= $email ?></td>
                            <td>
                                <!-- <button class="btn btn-primary user-update-btn"> -->
                                <a class="btn btn-primary user-update-btn" href="../user/update.php?updateid=<?php echo $id; ?>" class="text-light">Edit</a>
                                <!-- </button> -->
                                <a class="btn btn-danger btn btn-primary user-update-btn" href="../user/delete.php?deleteid=<?php echo $id; ?>" class="text-light">Delete</a></button>
                            </td>
                        </tr>
                <?php

                    }
                }

                ?>
    </div>






    </tbody>
    </table>
    </div>


</body>

</html>