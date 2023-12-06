<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
include '../helper.php';

$id = $_GET['updateid'];
// $id = $_GET[''];
// print_r($_GET);

if (isset($_POST["submit"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $newstype_id = $_POST['newstype_id'];

    // Check if a new image was uploaded
    if ($_FILES['file']['name']) {
        $result = image('file');
        // Update the image in the database only if a new image was uploaded
        $sql = "UPDATE news SET image=? WHERE ID=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $result, $id);
        $imageUpdateResult = mysqli_stmt_execute($stmt);
        if (!$imageUpdateResult) {
            die(mysqli_stmt_error($stmt));
        }
    }

    // Update the other fields in the database
    $sql = "UPDATE news SET newstype_id=?,title=?, description=? WHERE ID=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "issi", $newstype_id, $title, $description, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        header('location: ../news/index.php');
        exit();
    } else {
        die(mysqli_stmt_error($stmt));
    }
}

$sql = "SELECT * FROM news WHERE id = $id";
$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $title = $row['title'];
        $description = $row['description'];
        $newstype_id = $row['newstype_id'];
        // print_r($newstype_id) ;
        // die();
    } else {
        echo "No rows found.";
    }
} else {
    echo "Query failed: " . mysqli_error($con);
}
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
    <div class="container my-5">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" placeholder="Enter a title" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter a description" rows="10"><?php echo $description; ?></textarea>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="file" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>
            <div class="mb-5">
                <label for="name" class="form-label">Select a Newstype</label>
                <select name="newstype_id" class="form-select mb-5" aria-label="Default select example">
                    <option selected disabled>Newstype</option>
                    <?php
                    // Assuming you have a database connection established
                    // and a query to retrieve the newstypes from the database
                    $sql = "SELECT * FROM newstype";
                    $newstypesResult = mysqli_query($con, $sql);

                    // Loop through the result set and generate options
                    while ($newstypeRow = mysqli_fetch_assoc($newstypesResult)) {
                        $newstypeId = $newstypeRow['id'];
                        $newstypeName = $newstypeRow['name'];

                        $selected = ($newstypeId == $newstype_id) ? 'selected' : '';
                        echo "<option value=\"$newstypeId\" $selected>$newstypeName</option>";
                    }
                    ?>
                </select>
             </div>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>
</body>

</html>