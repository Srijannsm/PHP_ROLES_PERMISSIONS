<?php

include '../connect.php';

if (isset($_SESSION['role_id'])) {
  $roleid = $_SESSION['role_id'];
  $sql = "SELECT * FROM users WHERE role_id = $roleid";
  $result = mysqli_query($con, $sql);


  $dataArray = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $dataArray[] = $row;
  }
  // print_r ($dataArray);
  $_SESSION['login'] = $dataArray;

  $roleData = [];
  $role_id = 'role_id';

  foreach ($_SESSION['login'] as $row) {
    if (isset($row[$role_id])) {
      $roleData[] = $row[$role_id];
    }
  }

  $_SESSION['user_role_id'] = $roleData;

  if (isset($_SESSION['user_role_id'])) {

    $userRoleID = $_SESSION['user_role_id'][0];


    $query = "SELECT p.name FROM roles_permissions rp INNER JOIN permissions p ON rp.permission_id=p.id WHERE rp.role_id = $userRoleID";
    $result = mysqli_query($con, $query);

    // Store the permissions in an array
    $userPermissions = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $userPermissions[] = $row['name'];
    }
    // print_r($userPermissions);

    // Additional code here, if needed for handling permissions
  }
}





?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>DASHBOARD</title> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/b0f9b0e1e8.js" crossorigin="anonymous"></script>

</head>

<body>
<?php
// ...

 $page = $_SERVER['PHP_SELF'];
//  echo $page;
//  die();

?>
<style>
  .container .navbar-brand {
  font-size: 20px;
  font-weight: 600;
  /* color: #F97060; */
  font-weight: bold;
}

.container .navbar-brand.active,
.container .navbar-brand:hover {
  color: #F97060;
  font-weight: bold;
}

  .navbar-nav .nav-link {
    color: #333;
    font-weight: normal; /* Set the default font weight for the nav links */
  }
  

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #F97060;
    font-weight: bold; /* Change the font weight to bold for the hover and active states */
  }
</style>

<div class="container">
  <nav class="navbar navbar-expand-lg bg-body-tertiary my-2" style="background-color: #AADEDE;">
    <div class="container">
      <?php if (in_array('view_dashboard', $userPermissions)) { ?>
        <a class="navbar-brand <?php echo ($page == '/project1/dashboard/index.php') ? 'active' : ''; ?> "  href="../dashboard/index.php">Dashboard</a>
      <?php } ?>

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item">
    <?php if (in_array('view_news', $userPermissions)) { ?>
      <a class="nav-link <?php echo ($page == '/project1/news/index.php') ? 'active' : ''; ?>" href="../news/index.php">News</a>
    <?php } ?>
  </li>
  <li class="nav-item">
    <?php if (in_array('view_roles', $userPermissions)) { ?>
      <a class="nav-link <?php echo ($page == '/project1/role/index.php') ? 'active' : ''; ?>" href="../role/index.php">Roles</a>
    <?php } ?>
  </li>
  <li class="nav-item">
    <?php if (in_array('view_permissions', $userPermissions)) { ?>
      <a class="nav-link <?php echo ($page == '/project1/permission/index.php') ? 'active' : ''; ?>" href="../permission/index.php">Permissions</a>
    <?php } ?>
  </li>
</ul>


      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link " href="../index.php">Portal</a>
        </li>
        <li class="nav-item">
          <?php if (in_array('view_users', $userPermissions)) { ?>
            <a class="nav-link <?php echo ($page == '/project1/user/index.php') ? 'active' : ''; ?>" href="../user/index.php"><i class="fa-solid fa-users fa-2xl"></i></a>
          <?php } ?>
        </li>
        <li class="nav-item">
          <?php if (in_array('view_profile', $userPermissions)) { ?>
            <a class="nav-link <?php echo ($page == '/project1/profile/index.php') ? 'active' : ''; ?>" href="../profile/index.php"><i class="fa-solid fa-address-card fa-2xl"></i></i></a>
          <?php } ?>
        </li>
        <li class="nav-item">
          <?php if (in_array('view_logout', $userPermissions)) { ?>
            <a class="nav-link" href="../logout/index.php">Logout</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </nav>


  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


              
</body>


</html>