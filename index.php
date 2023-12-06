<?php
session_start();
include './connect.php';
// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
//     // header('Location: ../dashboard/index.php'); // Use 'Location' header to redirect
//     exit;
// }

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

        .card .card-body {
            height: 200px;
            overflow: hidden;
        }

        a {
            text-decoration: none;
        }
    </style>
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
                                <a class="nav-link" href="./category.php?newstypeid=<?= $id ?>"><?= $name ?></a>
                            </li>

                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./otherNews.php">APInews</a>
                        </li>
                        
                        <?php
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {?>
                                <li class="nav-item">
                            <a class="nav-link" href="./file.php">NewsUpload</a>
                        </li>
                                
                           <?php }
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
            <form class="d-flex" role="search" method="get" action="search.php?newstypeid=">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>


    </div>


    <?php
    $i = 0;
    $sql = "SELECT * FROM news";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die('Query failed: ' . mysqli_error($con));
    }

    $unique_news = [];
    foreach ($result as $row) {
        $id = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $created_by = $row['created_by'];
        $image = $row['image'];


        // Check if the news is already in the unique news array
        $found = false;
        foreach ($unique_news as $unique_row) {
            if ($id == $unique_row['id']) {
                $found = true;
                break;
            }
        }

        // Add the news item to the unique news array if it is not already in the array
        if (!$found) {
            $unique_news[] = $row;
        }
    }

    $num_rows = mysqli_num_rows($result);
    ?> <div class="container">
        <div class="row">
            <?php foreach ($unique_news as $row) : ?>
                <div class="col-md-4 my-2">
                    <?php
                    $url = 'news.php?newsid=' . urlencode($row['id']);

                    // Check if the image URL starts with './' (file directory image)
                    if (strpos($row['image'], '../') === 0) {
                        
                        $image1 = str_replace('../', './', $row['image']);
                        $image2 = "./image/No_Image_Available.jpg";
                        $imageSource = file_exists($image1) ? $image1 : $image2;
                    } else {
                        // URL-based image
                        $imageSource = $row['image'];
                    }
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
            <?php endforeach; ?>
        </div>
    </div>











</body>

</html>