<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/custom.css"> -->
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <div class="container">


        <button onclick="window.location.href='../role/create.php'" class="btn btn-primary my-5">Create a Role</button>


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
                    $sql = "SELECT * FROM roles ";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            // $password = $row['Password'];
                            // $email = $row['Email']; 
                    ?>

                            <!-- echo ' -->
                            <tr>
                                <th scope="row"><?= $id ?></th>
                                <td><?= $name ?></td>
                                <!-- <td><?= $password ?></td>
                                <td><?= $email ?></td> -->
                                <td>
                                    <a class="btn btn-primary user-update-btn text-light" href="../role/update.php?updateid=<?php echo $id; ?>">Update</a>
                                    <a class="btn btn-danger btn btn-primary user-update-btn" href="../role/delete.php?deleteid=<?php echo $id; ?>" class="text-light">Delete</a></button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>



        </div>
        </form>
    </div>
    </tbody>
    </table>
    </div>
    </div>


</body>

</html>