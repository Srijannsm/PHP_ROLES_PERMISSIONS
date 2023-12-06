<?php
    require '../session.php';
    include '../connect.php';
    include '../navbar/navbar.php';


    // Assuming you have a database connection in $con
    // echo '<pre>';
    // print_r($_SESSION);
    // echo '</pre>';
    // Fetch user data from the database based on the logged-in session
    if (isset($_SESSION['user_id'])) {
    //     echo "User ID in Session: " . $_SESSION['user_id'];
    // } else {
    //     echo "User ID not found in session.";
    
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($con, $query);}

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title" style="text-align: center;">User Profile</h3>
                    </div>
                    <div class="card-body" style="background: linear-gradient(to right, #f5f5f5, #e1f5e1); padding: 20px;">
                        <?php if (isset($user)): ?>
                            <div class="text-center">
                                <img src="<?php echo $user['image']; ?>" alt="User Avatar" class="img-fluid rounded-circle" width="150">
                            </div>

                            <div class="mt-4" style="text-align: left;">
                                <h5>Name:   <span style="display: inline-block; width: 10px;"></span>    <?php echo $user['name']; ?></h5>
                                <!-- <h5>Username:  <span style="display: inline-block; width: 10px;"></span> <?php echo $user['username']; ?></h5> -->
                                <h5>Email:    <span style="display: inline-block; width: 10px;"></span>  <?php echo $user['email']; ?></h5>
                                <h5>Password:  <span style="display: inline-block; width: 10px;"></span> <?php echo $user['password']; ?></h5>
                                
                                <!-- Add other user details here -->
                            </div>
                            
                        <?php else: ?>
                            <p>No user data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
