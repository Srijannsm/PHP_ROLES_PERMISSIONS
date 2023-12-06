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



        <?php if (in_array('create_newstype', $userPermissions)) { ?>
            <button onclick="window.location.href='../newstype/index.php'" class="btn btn-secondary my-5">View NewsType</button>
        <?php } ?>
        

        
            
        <div class="container">
            <div class="text-end">
                <div class=" d-flex justify-content-end mb-5">
                    <label for="filter-select" class="form-label"> Sort by: </label>
                    <select style="width:300px" id="filter-select" class="form-select form-select-sm smaller-select" aria-label=".form-select-sm" onchange="reloadWithSorting(this.value)">
                        <option value="asc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'asc') {
                                                echo 'selected';
                                            } ?>>Ascending</option>
                        <option value="desc" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'desc') {
                                                    echo 'selected';
                                                } ?>>Descending</option>
                    </select>
                </div>
            </div>
        </div>

        <script>
            function reloadWithSorting(sortOrder) {
                var baseUrl = window.location.href.split('?')[0]; // Get the base URL without query parameters
                var newUrl = baseUrl + '?sort=' + sortOrder; // Construct the new URL with the selected sort order
                window.location.href = newUrl; // Reload the page with the new URL
            }
        </script>


        <?php
        $sort = '';
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $userId = $_SESSION['user_id'];
        $role_id = $_SESSION['role_id'];
        // var_dump($role_id);

        $sql = "SELECT name FROM roles WHERE id=$role_id ";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $role = $row['name'];
        // var_dump($role);

    

        
        if ($row['name'] == 'admin') {
            $sql = query('news', $sort);
            $result = mysqli_query($con, $sql);
        } else {
            $sql = queryGet('news', $sort);
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        ?>

        <style>
            .users-table th,
            .users-table td {
                border-right: 0.5px solid black;
            }

            .users-table th:last-child,
            .users-table td:last-child {
                border-right: 1px solid black;
            }
        </style>

        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th scope="col">SNo. </th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <?php 
                    if($role=='admin'){?><th scope="col">Created_by</th><?php } ?>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $name = $row['name'];
                        
                        // echo $image;
                        // die
                        // $comment = $row['comment'];
                        
                ?>
                        <tr>
                            <th scope="row"><?= $id ?></th>
                            <?php
                    

                    // Check if the image URL starts with './' (file directory image)
                    if (strpos($row['image'], './') === 0) {
                        
                        $image1 = str_replace('../', './', $row['image']);
                        $image2 = "./image/No_Image_Available.jpg";
                        $imageSource = file_exists($image1) ? $image1 : $image2;
                    } else {
                        // URL-based image
                        $imageSource = $row['image'];
                    }
                    ?>
                            <td><img src="<?= $imageSource?>" alt="News Picture" width="300"></td>

                            <td><?= $title ?></td>
                            <td><?php
                                $limitedDescription = substr($description, 0, 70); // Limit to 50 characters
                                echo $limitedDescription;
                                ?></td>
                           <?php 
                    if($role=='admin'){?> <td><?= $name ?></td><?php }?>
                            <td>
                                <div class="d-flex flex-column">
                                    <button type="button" class="btn btn-very-light-green mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $id ?>">
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
                                    <a class="btn btn-primary user-update-btn mb-2" href="../news/update.php?updateid=<?= $id ?>&hello" class="text-light">Edit</a>
                                    <a class="btn btn-danger btn btn-primary user-update-btn" href="../news/delete.php?deleteid=<?= $id ?>" class="text-light">Delete</a>
                                    
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <style>
        .btn-very-light-green {
            background-color: #e8f5e9;
            color: #000000;
            border-color: #e8f5e9;
        }
    
        .btn-very-light-green:hover {
            background-color: #dcedc8;
            border-color: #dcedc8;
        }
    </style>
    
</body>

</html>
