<?php
session_start();
include './connect.php';

$id = $_GET['newsid'];
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  // Handle the case when 'user_id' is not set in the session
  $user_id = null; // or any default value you want to assign
}

// echo $user_id;
// die();
if (isset($_POST['submit'])) {

  $comment = $_POST['comment'];
  if ($comment != '') {



    $sql = "INSERT INTO comments (news_id, comment, commented_by) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $id, $comment, $user_id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
      header('location:news.php?newsid=' . $id);
    } else {
      echo 'comment not found';
    }
  } else {
    echo
    '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Please don`t leave the textarea empty before posting it.</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
}








?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/b0f9b0e1e8.js" crossorigin="anonymous"></script>

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
                            $nav_id = $row['id'];
                            $name = $row['name'];
                            $activeClass = ($nav_id == $id) ? 'active' : '';
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $activeClass ?>" href="./category.php?newstypeid=<?= $nav_id ?>"><?= $name ?></a>
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


  <style>
    .bg-light-sky-blue {
      background-color: lightskyblue !important;
    }
  </style>




  <?php
  $sql = "SELECT * FROM news WHERE id = $id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $title = $row['title'];
  $description = $row['description'];
  $image = $row['image'];
  $views = $row['views'];
  if (strpos($row['image'], '../') === 0) {
    $image1 = str_replace('../', './', $row['image']);
    $image2 = "./image/No_Image_Available.jpg";
    $imageSource = file_exists($image1) ? $image1 : $image2;
} else {
    // URL-based image
    $imageSource = $row['image'];
}

  $sql = "SELECT DATE_FORMAT(created_date, '%Y %b %e') AS formatted_date FROM news WHERE id = $id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $created_date = $row['formatted_date'];

  $sql = "UPDATE news SET views = views + 1 where id=$id ";
  $result = mysqli_query($con, $sql);

  $sql = "SELECT COUNT(comments.id) AS comment_count
  FROM comments
  INNER JOIN news ON comments.news_id = news.id
  WHERE news.id = $id";

  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $comment_count = $row['comment_count'];



  ?>

  <form method="post">
    <div class="container my-4">
      <div class="news-header my-4">
        <h2 class="news-title"><?php echo $title; ?></h2>
      </div>
      <p style="display: inline-flex;">
        <i class="fa fa-eye fa-2x" aria-hidden="true"></i>
        <span style="font-size: 1.2em;"><?php echo "   $views"; ?></span>
</p>


      <div class="news-content my-4">
        <div class="news-image-container my-4">
          <img src="<?php echo $imageSource; ?>" alt="News Image" class="news-image">
        </div>
        <p class="news-date">Published on <?php echo $created_date; ?></p>
        <div class="news-description my-4">
          <p><?php echo $description; ?></p>
        </div>
      </div>

      <?php

      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {


      ?>
        <div class="form-floating">
          <div class="d-flex flex-row align-items-end">
            <div class="flex-grow-1">
              <textarea name="comment" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
            </div>
          </div>
          <div class="py-4">
            <button type="submit" class="btn btn-primary" name="submit">Post</button>
          </div>
        </div>

        <label for="floatingTextarea2">Comments</label>
    </div>

    </div>

    </div>
  <?php
      } else {

  ?>
    <div class="flex-grow-1">
      <textarea name="comment" class="form-control" placeholder="Please Login to comment.." id="floatingTextarea2" style="height: 100px"></textarea>
    </div>
    <?php
        $url = './login/index.php?newsid=' . urlencode($id);

    ?>
    <p class="text-start">Please <a href="<?= $url ?>" class="btn btn-fading my-3">Login</a> to comment.</p>
    <label class="floatingTextarea2 text-bold" >Comments</label>
    <style>
      .text-bold{
        font-weight: bold;
 
      }
      .btn-fading {

        background-color: lightsteelblue;
        border-color: #f8f9fa;
        color: #343a40;
        transition: background-color 0.3s ease;
      }

      .btn-fading:hover {
        background-color: #e9ecef;
      }
    </style>

  <?php
      }
  ?>


  <!-- 
  <style>
    .container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #ffffff;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

  </style> -->
  </div>
  </form>



  <style>
    .news-container {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .news-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .news-title {
      font-size: 30px;
      margin: 0;
    }

    .news-date {
      font-size: 15px;
      color: #888;
      margin: 0;
    }

    .news-content {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .news-image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      max-width: 50%;
      margin-bottom: 20px;
    }

    .news-image {
      width: 100%;
      height: auto;
      border-radius: 4px;
    }

    .news-description {
      font-size: 20px;
      line-height: 1.5;
    }

    .comment-section {
      margin-top: 20px;
    }

    .comment-section h3 {
      margin: 0;
    }
  </style>

  <div class="container">
    <?php
    $sql = "SELECT comments.comment, users.name, users.image
  FROM comments
  INNER JOIN users ON comments.commented_by = users.id
  INNER JOIN news ON comments.news_id = news.id
  WHERE news.id = $id";
  ?>
   <p style="display: inline-flex;">
      <i class="fa fa-comments fa-2x" aria-hidden="true"></i>
      <span style="font-size: 1.2em;"><?= $comment_count ?> </span>
</p>
<?php

    $result = mysqli_query($con, $sql);
    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $image1 = str_replace('../', './', $row['image']);
        
        // echo $image1;
        // die();
        $name = $row['name'];
        $comment = $row['comment'];
        // print_r($row);
        // die();
        // echo '<div class="comment-box">
        // <div class="comment-box-header">
        // <h3>'.$name=$row['name'].'</h3>
        // </div>
        // <div class="comment-box-body">
        // <p>'.$row['comment'].'</p>
        // </div>
        // </div>';
        echo '
        <div class="comment-container">
        <div class="media my-3">
            <img src="'. $image1 .'" width="40px" class="mr-3 rounded-circle" alt="User Avatar">
            <div class="media-body">
                <p class="font-weight-bold">'. $name .'</p>
                <div class="comment-text">'. $comment .'</div>
            </div>
        </div>
    </div>
    <br>
';
      }
    }

    ?>
    <style>

.comment-container {
  background-color: #f9f9f9;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* .comment-container .media {
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
  margin-bottom: 10px;
} */

.comment-container .media:last-child {
  border-bottom: none;
  padding-bottom: 0;
  margin-bottom: 0;
}



      .media {
        display: flex;
        align-items: flex-start;
        margin-top: 10px;
      }

      .media img {
        border-radius: 50%;
      }

      .media-body {
        flex: 1;
      }

      .font-weight-bold {
        font-weight: bold;
        padding-left: 1%;
        margin-bottom: 0%;
      }

      .comment-text {
        background-color: #f5f5f5;
        padding-left: 1%;
        margin-bottom: 20px;
        border-radius: 2px;
      }
    </style>
  </div>



</body>

</html>