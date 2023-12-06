<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php'; ?>
<?php
$id = $_GET['updateid'];
$sql = "SELECT * FROM permissions WHERE ID = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Check if a record was found
if ($row) {
    $name = $row['name'];
    // $display_name = $row['display_name'];
    $display = preg_replace('/[\s\W_]+/', '', strtoupper($name));
    $role_id = $row['id'];
} else {
    // Handle the case when the record is not found (e.g., display an error message or redirect to an error page)
}

if (isset($_POST["submit"])) {
    $name = $_POST['permission'];


    $sql = "UPDATE permissions SET name='$name', display_name='$display' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location:../permission/index.php');
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>
<div class="container">

    <form method='post'>
        <div class="my-3">
            <label for="exampleInputEmail1" class="form-label">Permission</label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="permission">

        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</div>