<?php
session_start();
include './connect.php';

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
                            $activeClass = 'active';

                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./category.php?newstypeid=<?= $id ?>"><?= $name ?></a>
                            </li>

                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeClass ?>" href="./otherNews.php">APInews</a>
                        </li>
                    </ul>
                </div>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
                    <a href="./dashboard/index.php" class="btn btn-primary">Dashboard</a>
                <?php else : ?>
                    <a href="./login/index.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>

    <div class="container my-4">
        <form class="d-flex" role="search" method="post" action="othernews.php">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php if (isset($_POST['search'])) {
                                                                                                                                echo $_POST['search'];
                                                                                                                            } ?>">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
     </div>

    <div class="container my-3">
        <?php if (isset($_POST['search'])) { ?><h1>Search results for <em>"<?php if (isset($_POST['search'])) {
                                                                                echo $_POST['search'];
                                                                            } ?>"</em></h1><?php } ?>
    </div>

    <?php
    // Checking if the form is submitted and the search query is available in $_POST
    if (isset($_POST['search'])) {
        $search_query = $_POST['search'];
    } else {
        $search_query = '';
    }
    ?>



    <div class="container my-3">
        <div class="row">
            <?php
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, "https://newsdata.io/api/1/news?apikey=pub_26416e32cddc918d192b8672d8ebd3aa2c7e4&q=$search_query");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($output, true);

            if ($response['status'] === 'success') {
                $data = $response['results'];
                foreach ($data as $post) {
                    // Access and work with the retrieved posts data
            ?>
                    <div class="col-md-4 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $post['title'] ?></h5>
                                <p class="card-text"><?= substr($post['description'], 0, 100) ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="<?= $post['link'] ?>" class="btn btn-primary btn-sm">Read More</a>
                                <?php if (is_array($post['creator'])) : ?>
                                    <p class="text-muted my-1">Author: <?= implode(', ', $post['creator']) ?></p>
                                <?php else : ?>
                                    <p class="text-muted my-1">Author: <?= $post['creator'] ?></p>
                                <?php endif; ?>
                                <p class="text-muted my-1">Publication Date: <?= $post['pubDate'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                // Handle the case when there are no results or invalid response
                ?>
                <div class="container">
                    <div class="alert alert-warning" role="alert">
                        No posts found!
                    </div>
                </div>
            <?php
            }

            ?>
        </div>
    </div>




</body>

</html>