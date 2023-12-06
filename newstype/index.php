<?php
require '../session.php';
include '../connect.php';
include '../navbar/navbar.php';
include '../helper.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php if (in_array('create_newstype', $userPermissions)) { ?>
            <button onclick="window.location.href='../newstype/create.php'" class="btn btn-secondary my-5">Create NewsType</button>
        <?php } ?>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total News</th>
                    <th scope="col">Oerations</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT newstype.id AS newstype_id,status, newstype.name, COUNT(news.id) AS total_news
                FROM newstype
                LEFT JOIN news ON newstype.id = news.newstype_id
                -- WHERE newstype.status = '1'
                GROUP BY newstype.id";
                $result = mysqli_query($con, $sql);
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $newstype_id = $row['newstype_id'];
                    $name = $row['name'];
                    $status = $row['status'];
                    $total_news = $row['total_news'];
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $name ?></td>
                        <td>
                            <?php if ($status == 1) { ?>
                                <span class="status-on">ON</span>
                            <?php } else { ?>
                                <span class="status-off">OFF</span>
                            <?php } ?>
                        </td>
                        <td><?= $total_news ?></td>
                        <td>
                            <a class="btn btn-primary user-update-btn text-light" href="../newstype/update.php?updateid=<?php echo $newstype_id; ?>">Edit</a>
                            <a class="btn btn-danger btn btn-primary user-update-btn" href="../newstype/delete.php?deleteid=<?php echo $newstype_id; ?>" class="text-light">Delete</a></button>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
    <style>
        .status-on {
            color: green;
        }

        .status-off {
            color: red;
        }
    </style>

</body>

</html>