<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php'; ?>
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['permission'];
    $display = preg_replace('/[\s\W_]+/', '', strtoupper($name));



    $sql = "INSERT INTO permissions (name,display_name) VALUES('$name', '$display')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // echo'successful';
        header('location:../permission/index.php');
    } else {
        die(mysqli_error($con));
    }
}
?>
<!doctype html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/custom.css"> -->
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <div class="container">
        <form class='my-4' method='post'>
            <div class="my-3">
                <label for="exampleInputEmail1" class="form-label">New Permissions</label>
                <input type="text" class="form-control" name="permission">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>

        </form>
    </div>

</body>

</html>