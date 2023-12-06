<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';;?>
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected role and permissions
    $selectedRole = $_POST['role'];
    $selectedPermissions = $_POST['permissions'];

    // Clear existing role permissions for the selected role
    $sql = "DELETE FROM roles_permissions WHERE role_id = $selectedRole";
    mysqli_query($con, $sql);

    // Insert the selected permissions for the role
    foreach ($selectedPermissions as $permission) {
        $insertSql = "INSERT INTO roles_permissions (role_id, permission_id) VALUES ($selectedRole, $permission)";
        mysqli_query($con, $insertSql);
    }

    // Redirect to a success page or perform any additional actions
    header('Location: ../permission/index.php');
    exit();
}

// Fetch roles from the database
$rolesSql = "SELECT * FROM roles";
$rolesResult = mysqli_query($con, $rolesSql);

// Fetch permissions from the database
$permissionsSql = "SELECT * FROM permissions";
$permissionsResult = mysqli_query($con, $permissionsSql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERMISSIONS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <div class="container">


        <button onclick="window.location.href='create.php'" class="btn btn-primary my-5">Create a Permission</button>

        <div class="container mt-5 d-flex justify-content-center">
        <table class="table table-bordered w-50">
                <thead>
                    <tr>
                        <th scope="col">SNo.</th>
                        <th scope="col">Name</th>
                        <!-- <th scope="col">Password</th>
            <th scope="col">E-mail</th> -->
                        <th scope="col">Operations</th>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    $sql = "SELECT * FROM permissions ";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $display=$row['display_name'];
                            // echo $display;
                            // die();
                            // $password = $row['Password'];
                            // $email = $row['Email']; 
                    ?>

                            <!-- echo ' -->
                            <tr>
                                <th scope="row"><?= $id ?></th>
                                <td><?= $display ?></td>
                                <!-- <td><?= $password ?></td>
                                <td><?= $email ?></td> -->
                                <td>
                                    <a class="btn btn-primary user-update-btn text-light" href="../permission/update.php?updateid=<?php echo $id; ?>">Edit</a>
                                    <a class="btn btn-danger btn btn-primary user-update-btn" href="../permission/delete.php?deleteid=<?php echo $id; ?>" class="text-light">Delete</a></button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>



        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>