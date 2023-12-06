<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';

$id = $_GET['updateid'];


// Retrieve the existing data from the database
$sql = "SELECT * FROM roles WHERE ID = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Check if a record was found
if ($row) {
    $name = $row['name'];
    $role_id = $row['id'];
} else {
    // Handle the case when the record is not found (e.g., display an error message or redirect to an error page)
}

// Retrieve the assigned permissions for the role
$permissionsSql = "SELECT p.*, rp.role_id
                   FROM permissions p
                   INNER JOIN roles_permissions rp ON p.id = rp.permission_id AND rp.role_id = $id";
$permissionsResult = mysqli_query($con, $permissionsSql);
$assignedPermissions = array();
while ($permissionRow = mysqli_fetch_assoc($permissionsResult)) {
    $assignedPermissions[] = $permissionRow['id'];
}

// Close the database connection

if (isset($_POST["submit"])) {
    $name = $_POST['role'];
    $selectedPermissions = $_POST['permissions'];

    $sql = "UPDATE roles SET name='$name' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // Delete existing role permissions
        $deletePermissionsSql = "DELETE FROM roles_permissions WHERE role_id=$id";
        mysqli_query($con, $deletePermissionsSql);

        // Insert the selected permissions for the role
        foreach ($selectedPermissions as $permission) {
            $insertPermissionSql = "INSERT INTO roles_permissions (role_id, permission_id) VALUES ($id, $permission)";
            mysqli_query($con, $insertPermissionSql);
        }

        header('location: ../role/index.php');
        exit();
    } else {
        die(mysqli_error($con));
    }
}

$rolesSql = "SELECT * FROM roles";
$rolesResult = mysqli_query($con, $rolesSql);

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
                <input type="text" class="form-control" value="<?php echo $name; ?>" name="role">
            </div>
            <label for="permissions" class="form-label">Select permissions</label>
            <?php while ($row = mysqli_fetch_assoc($permissionsResult)) : ?>
                <?php
                $permissionId = $row['id'];
                $isChecked = '';
                if (in_array($permissionId, $assignedPermissions)) {
                    $isChecked = 'checked';
                }
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $permissionId; ?>" id="permission-<?php echo $permissionId; ?>" <?php echo $isChecked; ?>>
                    <label class="form-check-label" for="permission-<?php echo $permissionId; ?>">
                        <?php echo $row['name']; ?>
                    </label>
                </div>
            <?php endwhile; ?>




            <button type="submit" name="submit" class="btn btn-primary my-4">Change</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>