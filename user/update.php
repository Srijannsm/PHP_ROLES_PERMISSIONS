<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
include '../helper.php';
?>
<?php
$id = $_GET['updateid'];
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    // $image = $_FILES['file'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];


    if ($_FILES['file']['name']) {
        $result = image('file');
        // echo $result;
        // die();
        // Update the image in the database only if a new image was uploaded
        $sql = "UPDATE users SET image=? WHERE ID=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $result, $id);
        $imageUpdateResult = mysqli_stmt_execute($stmt);
        if (!$imageUpdateResult) {
            die(mysqli_stmt_error($stmt));
        }
    }

   



    $sql = "UPDATE users SET Name='$name',Password='$password', Email='$email', role_id='$role_id' WHERE ID=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location: ../user/index.php');
    } else {
        die(mysqli_error($con));
    }
}
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($con, $sql);

if ($result) {
    // Fetch the row from the result set
    $row = mysqli_fetch_assoc($result);
    
    // Check if the row exists and fetch the values
    if ($row) {
        $name = $row['name'];
        $password = $row['password'];
        $email = $row['email'];
        $role_id = $row['role_id'];
        // Use the fetched values as needed
        // ...
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>CRUD</title>
</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <div class="container my-5">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Enter a name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" placeholder="Enter a password" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Enter an e-mail" autocomplete="off">
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Profile Picture</label>
                <input type="file" class="form-control" name="file" id="inputGroupFile02">

            </div>

            <div class="mb-5">
                <label for="name" class="form-label">Select a role</label>
                <select name="role_id" class="form-select mb-5" aria-label="Default select example">
                    <option selected disabled>Role</option>
                    <?php
                    // Assuming you have a database connection established
                    // and a query to retrieve the roles from the database
                    $sql = "SELECT * FROM roles";
                    $rolesResult = mysqli_query($con, $sql);

                    // Loop through the result set and generate options
                    while ($roleRow = mysqli_fetch_assoc($rolesResult)) {
                        $roleId = $roleRow['id'];
                        $roleName = $roleRow['name'];
                        $selected = ($roleId == $role_id) ? 'selected' : '';
                        echo "<option value=\"$roleId\" $selected>$roleName</option>";
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn btn-primary my-2" name="submit">Update</button>
        </form>
    </div>


</body>

</html>