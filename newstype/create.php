<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php'; ?>
<?php

if (isset($_POST['submit'])) {
    $name = $_POST['permission'];
    $status = $_POST['status'];
    // echo $status;
    // die();


    $sql = "INSERT INTO newstype (name,status) VALUES('$name', '$status')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // echo'successful';
        header('location:../newstype/index.php');
    } else {
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <div class="container">
        <form class='my-4' method='post'>
            <div class="my-3">
                <label for="exampleInputEmail1" class="form-label font-weight-bold">New Type</label>
                <input type="text" class="form-control" name="permission" value="create a newstype">
            </div>
            <div class="my-3">
                <select class="form-select" name="status" aria-label="Default select example">
                    <option selected>Select Status</option>
                    <option value="1">On</option>
                    <option value="0">Off</option>
                    
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>

        </form>
    </div>
</body>

</html>