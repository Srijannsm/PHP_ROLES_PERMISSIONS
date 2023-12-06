<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
include '../helper.php';

if (isset($_POST["submit"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_by = $_SESSION['user_id'];
    $newstypeid = $_POST['newstype_id'];
    $result = image('file');
    echo $result;
    die();
    

        // Prepare the SQL statement
    $sql = "INSERT INTO news (image,newstype_id, title, description, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    // Bind the parameters to the statement
    mysqli_stmt_bind_param($stmt, "sisss", $result,$newstypeid, $title, $description, $created_by);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header('location: ../news/index.php');
        exit();
    } else {
        die(mysqli_stmt_error($stmt));
    }
    }
    $newstypeSql = "SELECT * FROM newstype";
    $newstypeResult = mysqli_query($con, $newstypeSql);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create News</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container my-5">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter a title" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter a description" rows="10"></textarea>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="file" id="inputGroupFile02">
                <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
            </div>
            <div class="mb-5">
            <select name="newstype_id" class="form-select my-4" aria-label="Default select example">
            <option selected>Choose a Newstype</option>
            <?php
                // Assuming you have a database connection established
                // and a query to retrieve the names from the database
                $sql = "SELECT * FROM newstype";
                $result = mysqli_query($con, $sql);

                // Loop through the result set and generate options
                while ($row = mysqli_fetch_assoc($result)) {
                    $newstype_id = $row['id'];
                    $newstype_name = $row['name'];
                    echo "<option value=\"$newstype_id\">$newstype_name</option>";
                }
                ?>

            </select>
            </div>
            <button type="submit" class="btn btn-primary my-5" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>


