<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
include '../helper.php';


if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];
    $result = image('file');


    // // Handle uploaded image
    // $image = $_FILES['file'];
    // // print_r($image);
    // $imagefilename = $image['name'];
    // // print_r($imagefilename);
    // // die();
    // $imageTmpName = $image['tmp_name'];
    // // print_r($imageTmpName);
    // // die();
    // $filename_separated = explode('.', $imagefilename);
    // // print_r($filename_separated);
    // // die();
    // $file_extension = strtolower($filename_separated[1]);
    // // print_r($file_extension);
    // // die();
    // $extension = array('jpg', 'jpeg', 'png');
    // if (in_array($file_extension, $extension)) {
    //     $imagePath = '../image/' . $imagefilename;
    //     //     print_r($imagePath);
    //     // die();
    //     move_uploaded_file($imageTmpName, $imagePath);

        $sql = "INSERT INTO users (image, name, password, email, role_id) VALUES ('$result','$name', '$password', '$email', '$role_id')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            header('location: ../user/index.php');
            exit();
        } else {
            die(mysqli_error($con));
        }
    }

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>CRUD</title>
</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <div class="container my-5">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter a name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter a password" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Enter an e-mail" autocomplete="off">
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Profile Picture</label>
                <input type="file" class="form-control" name="file" id="inputGroupFile02">

            </div>

            <label for="name" class="form-label">Select a role</label>

            <select name="role_id" class="form-select mb-5" aria-label="Default select example">
                <option selected>Role</option>

                <?php
                // Assuming you have a database connection established
                // and a query to retrieve the names from the database
                $sql = "SELECT * FROM roles";
                $result = mysqli_query($con, $sql);

                // Loop through the result set and generate options
                while ($row = mysqli_fetch_assoc($result)) {
                    $role_id = $row['id'];
                    $role_name = $row['name'];
                    echo "<option value=\"$role_id\">$role_name</option>";
                }
                ?>

            </select>

            <button type="submit" class="btn btn-primary my-5" name="submit">Submit</button>
        </form>
    </div>

</body>

</html>