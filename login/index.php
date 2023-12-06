<?php
session_start();

// Check if user is already logged in, redirect to home page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: ../dashboard/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../connect.php';

    $name = $_POST['name'];
    $password = $_POST['password'];

    $query = "SELECT id, role_id, name FROM users WHERE Name = '$name'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];
    $roleID = $row['role_id'];
    $userName = $row['name'];

    $_SESSION['role_id'] = $roleID;
    $_SESSION['user_id'] = $userId;
    $_SESSION['name'] = $userName;

    $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $role_id = $row['role_id'];

        $_SESSION['loggedin'] = true;
        $_SESSION['role_id'] = $role_id;

        if (isset($_GET['newsid']) && $_GET['newsid'] != '') {
            header("Location: ../news.php?newsid=" . $_GET['newsid']);
            exit();
        }
        // Redirect to a certain page based on role_id
        if ($role_id == 1) {
            header("Location: ../dashboard/index.php"); // Replace with the appropriate page for admins
            exit();
        } else {
            header("Location: ../dashboard/index.php"); // Replace with the appropriate page for users
            exit();
        }
    } else {
        // Login failed, display an error message or redirect to an error page
        $_SESSION['login_error'] = true;
        header('Location: ../login/index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Login</h1>

                <?php if (isset($_SESSION['login_error']) && $_SESSION['login_error'] === true) : ?>
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <div>Sorry! Invalid credentials.</div>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['login_error']); ?>

                <form class="mt-4" action="../login/index.php<?= isset($_GET['newsid']) && !empty($_GET['newsid']) ? '?newsid='.$_GET['newsid'] : '' ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="name" placeholder="Enter your username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
