<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
$roleID = $_SESSION['role_id'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>DASHBOARD</title>
</head>

<body>
    <?php
    if ($roleID == 1) { 
    ?>

        <div class="container" style="text-align: center;">
        <div class="d-flex justify-content-center">
            <div class="card-container ">
                <div class="card m-5 mt-4" style="width: 18rem; background: linear-gradient(to right, #f7fafc, #edf2f7);">
                    <div class="card-body">
                        <h5 class="card-title">USERS</h5>
                        <p class="card-text">Total number of Users:</p>
                        <?php
                        $sql = "SELECT COUNT(id) FROM users";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_row($result);
                        $count = $row[0];
                        // echo $count;
                        ?>
                        <!DOCTYPE html>
                        <html>

                        <head>

                            <style>
                                .large-count {
                                    font-size: 50px;
                                    /* Adjust the font size as needed */
                                    font-weight: bold;
                                }
                            </style>
                        </head>

                        <body>
                            <h1><span class="large-count"><?php echo $count; ?></span></h1>
                        </body>

                        </html>
                    </div>
                </div>





                <div class="card m-5 mt-4" style="width: 18rem; background: linear-gradient(to right, #f7fafc, #edf2f7);">
                    <div class="card-body">
                        <h5 class="card-title">ROLES</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Total number of roles:</h6>
                        <?php
                        $sql = "SELECT COUNT(id) FROM roles";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_row($result);
                        $count = $row[0];
                        // echo $count;
                        ?>
                        <!DOCTYPE html>
                        <html>

                        <head>

                            <style>
                                .large-count {
                                    font-size: 50px;
                                    /* Adjust the font size as needed */
                                    font-weight: bold;
                                }
                            </style>
                        </head>

                        <body>
                            <h1><span class="large-count"><?php echo $count; ?></span></h1>
                        </body>

                        </html>
                    </div>
                </div>
                <div class="card m-5 mt-4" style="width: 18rem; background: linear-gradient(to right, #f7fafc, #edf2f7);">
                    <div class="card-body">
                        <h5 class="card-title">PERMISSIONS</h5>
                        <p class="card-text">Total number of Permissions:</p>
                        <?php
                        $sql = "SELECT COUNT(id) FROM permissions";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_row($result);
                        $count = $row[0];
                        // echo $count;
                        ?>
                        <!DOCTYPE html>
                        <html>

                        <head>

                            <style>
                                .large-count {
                                    font-size: 50px;
                                    /* Adjust the font size as needed */
                                    font-weight: bold;
                                }
                            </style>
                        </head>

                        <body>
                            <h1><span class="large-count"><?php echo $count; ?></span></h1>
                        </body>

                        </html>
                    </div>
                </div>



                <!-- <div class="container my-5 row "> -->
                <!-- <?php
                $sql = "SELECT nt.name AS newstype_name, COUNT(n.id) AS total_news
            FROM `newstype` nt
            LEFT JOIN `news` n ON nt.id = n.newstype_id
            GROUP BY nt.id";
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $newstype_name = $row['newstype_name'];
                    $total_news = $row['total_news'];
                ?>
                    <div class="card m-5 mt-4" style="width: 18rem; background: linear-gradient(to right, #f7fafc, #edf2f7);">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $newstype_name; ?></h5>
                            <p class="card-text">Total number of news:</p>
                            <h1><span class="large-count"><?php echo $total_news; ?></span></h1>
                            <style>
                                .large-count {
                                    font-size: 50px;
                                    /* Adjust the font size as needed */
                                    font-weight: bold;

                                }
                            </style>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div> -->






    <?php
    } else {
    ?>

        <div class="container" style="text-align: center" ;>
            <div class="card my-5" style="width: 18rem; background: linear-gradient(to right, #f7fafc, #edf2f7);">
                <div class="card-body">
                    <h5 class="card-title">NEWS</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Total number of News:</h6>
                    <?php
                    $userId = $_SESSION['user_id'];
                    $sql = "SELECT COUNT(n.id) FROM news n JOIN users u ON u.id = n.created_by WHERE n.created_by = '$userId '";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_row($result);
                    $count = $row[0];
                    // echo $count;
                    ?>
                    <!DOCTYPE html>
                    <html>

                    <head>
                        <style>
                            .large-count {
                                font-size: 50px;
                                /* Adjust the font size as needed */
                                font-weight: bold;
                            }
                        </style>
                    </head>

                    <body>
                        <h1><span class="large-count"><?php echo $count; ?></span></h1>
                    </body>

                    </html>
                </div>
            </div>
        <?php
    }
        ?>
       
        <style>
            .card-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                /* Adjust the number of columns as needed */
            }
        </style>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
        </div>
        </div>
        
</body>

</html>