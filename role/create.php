<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected role and permissions
    $name = $_POST['role'];
    $selectedPermissions = $_POST['permissions'];

    // Insert the role into the database
    $insertRoleSql = "INSERT INTO roles (name) VALUES ('$name')";
    $result = mysqli_query($con, $insertRoleSql);
    if (!$result) {
        die(mysqli_error($con));
    }

    // Get the ID of the newly created role
    $selectedRole = mysqli_insert_id($con);

    // Insert the selected permissions for the role
    foreach ($selectedPermissions as $permission) {
        $insertPermissionSql = "INSERT INTO roles_permissions (role_id, permission_id) VALUES ($selectedRole, $permission)";
        mysqli_query($con, $insertPermissionSql);
    }

    // Redirect to a success page or perform any additional actions
    header('Location: ../role/index.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form class='my-4' method='post'>
            <div class="my-3">
                <label for="exampleInputEmail1" class="form-label">Role</label>
                <input type="text" class="form-control" name="role">
            </div>
            <label for="permissions" class="form-label">Select permissions</label>
            <?php while ($row = mysqli_fetch_assoc($permissionsResult)) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $row['id']; ?>" id="permission-<?php echo $row['id']; ?>">
                    <label class="form-check-label" for="permission-<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </label>
                </div>
            <?php endwhile; ?>
            <button type="submit" name="submit" class="btn btn-primary my-4">Create and assign</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>