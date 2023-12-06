<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php'; ?>
<?php
$id = $_GET['updateid'];
$sql = "SELECT * FROM newstype WHERE ID = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Check if a record was found
if ($row) {
    $name = $row['name'];
    // $role_id = $row['id'];
} else {
    // Handle the case when the record is not found (e.g., display an error message or redirect to an error page)
}

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $status = $_POST['status'];


    $sql = "UPDATE newstype SET name='$name',status='$status' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location:../newstype/index.php');
    } else {
        die(mysqli_error($con));
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>CRUD</title>
</head>

<body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<div class="container">
    <form class='my-4' method='post'>
        <div class="my-3">
            <label for="exampleInputEmail1" class="form-label" >Edit Type</label>
            <input type="text" class="form-control" name="name" value='<?= $name?>'>
        </div>
        <div class="my-3">
            <select class="form-select" name="status"  aria-label="Default select example">
                <option selected>Select Status</option>
                <option value="1">On</option>
                <option value="0">Off</option>
                
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>

    </form>
</div>

</body>

</html>
