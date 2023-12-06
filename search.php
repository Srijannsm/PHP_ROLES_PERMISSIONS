<?php
session_start();
include './connect.php';
// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
//     // header('Location: ../dashboard/index.php'); // Use 'Location' header to redirect
//     exit;
// }
// $id=$_GET['newstypeid'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>NewsPortal!</title>
    <style>
        .navbar {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #333;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-nav .nav-link {
            color: #333;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar-nav .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>

    <style>
        .bg-light-sky-blue {
            background-color: lightskyblue !important;
        }
    </style>

    <style>
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-group {
            display: flex;
            flex-wrap: nowrap;
        }

        a {
            text-decoration: none;
        }
    </style>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


</head>

<body>
<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="./index.php">NewsPortal</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <?php
                        $sql = "SELECT id, name FROM newstype WHERE status = 1";
                        $result = mysqli_query($con, $sql);

                        if (!$result) {
                            die('Query failed: ' . mysqli_error($con));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                        
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./category.php?newstypeid=<?=$id?>"><?= $name ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
                    <a href="./dashboard/index.php" class="btn btn-primary">Dashboard</a>
                <?php else : ?>
                    <a href="./login/index.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="container my-3">
            <form class="d-flex" role="search" method="get" action="search.php">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    <!-- SEARCH RESULTS -->

    <div class="container my-3">
        <h1>Search results for <em>"<?= $_GET['search'] ?>"</em></h1>

        <div class="search my-3">
            <?php
            $search = "%" . $_GET['search'] . "%";
            $i = 0;
            $sql = "SELECT *
        FROM news
        WHERE title LIKE '$search'
        OR description LIKE '$search'";

            $result = mysqli_query($con, $sql);

            if (!$result) {
                die('Query failed: ' . mysqli_error($con));
            } else {
                echo '<div class="row">'; // Start the row container

                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4 my-2">
                        <!-- converting a card into an anchor tag and sending its id with the URL -->
                        <?php
                        $url = 'news.php?newsid=' . urlencode($row['id']);
                        $image1 = str_replace('../', './', $row['image']);
                        $image2 = './image/No_Image_Available.jpg';
                        $imageSource = file_exists($image1)? $image1 : $image2 ;
                        ?>
                        <a href="<?= $url ?>">
                            <div class="card" style="width: 100%;">
                                <img src="<?= $imageSource ?>" class="card-img-top" alt="Card Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['title'] ?></h5>
                                    <p class="card-text"><?= substr($row['description'], 0, 70) ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">VEDA NEWS PORTAL</small>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                    $i++;
                    if ($i % 3 == 0) {
                        echo '</div><div class="row">'; // Close the current row and start a new row
                    }
                }

                echo '</div>'; // Close the final row container
            }
            ?>
        </div>
    </div>


    <style>
        .bg-light-sky-blue {
            background-color: lightskyblue !important;
        }
    </style>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>





    <style>
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
            /* Add small margin between cards */
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-group {
            display: flex;
            /* Display cards in a row */
            flex-wrap: nowrap;
            /* Prevent cards from wrapping to a new line */
        }

        a {
            text-decoration: none;
        }
    </style>












</body>

</html>