<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';

include '../helper.php';

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>NEWS</title>
</head>
<body>
    <div class="container">
        <?php if (in_array('create_news', $userPermissions)) { ?>
            <button onclick="window.location.href='../news/create.php'" class="btn btn-primary my-5">Create News</button>
        <?php } ?>

        <table class="table users-table">
            <thead>
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <!-- <th scope="col">Status</th> -->
                    <th scope="col">CreatedBy</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $userId = $_SESSION['user_id'];
                $name = query('news', $con);
   
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['name'];
                            // Display or use the retrieved name
                            // echo $name;
                        }
                    }

                                    
                // $sql = "SELECT n.*, u.name FROM news n JOIN users u ON u.id = n.created_by WHERE n.created_by = ?";
                $sql = queryGet('news');
                $stmt = mysqli_prepare($con, $sql);
                // mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $created_by = $row['created_by'];
                ?>

                        <tr>
                            <th scope="row"><?= $id ?></th>
                            <td><?= $title ?></td>
                            <td><?php
                                $limitedDescription = substr($description, 0, 80); // Limit to 100 characters
                                echo $limitedDescription;
                            ?></td>
                           <td> <?= $name ?>
                                </td>
                                    
                                    
                            <td>
                                <button type="button" class="btn btn-primary my-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $id ?>">
                                    View
                                </button>

                                <div class="modal fade .modal-lg" id="staticBackdrop<?= $id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel"><?= $title ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><?= $description ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-primary user-update-btn my-1" href="../news/update.php?updateid=<?= $id ?>" class="text-light">Edit</a>
                                <a class="btn btn-danger btn btn-primary user-update-btn my-1" href="../news/delete.php?deleteid=<?= $id ?>" class="text-light">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
