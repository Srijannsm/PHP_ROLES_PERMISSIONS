<?php
require './vendor/autoload.php'; // Include PhpSpreadsheet autoload
include './connect.php';
include './session.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $target_dir = "./uploads/"; // Target directory
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $fileType = pathinfo($target_file, PATHINFO_EXTENSION); // Get file type(extension_type)

    // Check if the file is an Excel file (xlsx)
    if (strtolower($fileType) == "xlsx") {
        // Move the uploaded file to the server's 'uploads' directory
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file); // Move the uploaded file

        try {
            // Read the Excel file and get the data
            $spreadsheet = IOFactory::load($target_file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // var_dump($data);
            // die();

            // Get the current date and time in the format 'Y-m-d H:i:s'
            $currentDate = date('Y-m-d H:i:s');

            // Loop through each row of data and insert into the database
            foreach ($data as $key => $row) {
                // Skip the first row (header row)
                if ($key === 0) {
                    continue;
                }

                // Extract data from the row
                if (!empty(array_filter($row))) {
                    // Extract data from the row
                    $image = !empty($row[1]) ? $row[1] : null;
                    $title = !empty($row[2]) ? $row[2] : null;
                    $description = !empty($row[3]) ? $row[3] : null;
                    $newstype_id = !empty($row[4]) ? $row[4] : null;

                    $sql = "SELECT name FROM newstype";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        $name = $row['name'];
                        
                        $array[] = $name;
                    }
                    // echo '<pre>';
                    //     print_r($array);
                    //     echo '</pre>';
                    //     die();

                    


                    if (in_array($newstype_id,$array)) {
                        $sql = "SELECT id
                                 FROM newstype
                                 WHERE name = '$newstype_id'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $newstype_id = $row['id'];
                        // echo $newstype_id;
                        // die();
                    }else{
                        $sql = "INSERT INTO newstype (name)
                                VALUES ('$newstype_id')";
                                    $result = mysqli_query($con,$sql);
                        $sql1 = "SELECT id FROM newstype WHERE name = '$newstype_id'";
                        $result1 = mysqli_query($con,$sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        $newstype_id = $row1['id'];
                    }
                    $user_id = $_SESSION['user_id'];
                    // echo $user_id;
                    // die();


                    // TODO: Add any necessary data validation here

                    // Create the SQL query string for insert operation
                    $sql = "INSERT INTO news (image, title, description, newstype_id, created_by, created_date) 
                        VALUES ('$image', '$title', '$description', $newstype_id, $user_id, '$currentDate')";

                    // Execute the SQL query
                    if (mysqli_query($con, $sql)) {
                        // You can remove this echo if you don't need individual success messages for each row
                        // echo "Data for row $key uploaded successfully!<br>";
                        header('Location: ./index.php');
                    } else {
                        echo "Error executing query for row $key: " . mysqli_error($con) . "<br>";
                    }
                }
            }
            // echo "All data uploaded successfully!";
        } catch (Exception $e) {
            echo "Error reading the Excel file: " . $e->getMessage();
        }

        // Close the database connection after all data is uploaded
        mysqli_close($con);
    } else {
        echo "Invalid file format. Only Excel files (xlsx) are allowed.";
    }
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


</head>

<body>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                Upload a .xlsx file :
            </div>
            <div class="card-body">

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="mb-3 my-2">

                        <!-- <label for="formFileLg" class="form-label">Upload a file</label> -->
                        <input class="form-control" type="file" id="formFile" name="file">


                        <button type="submit" name="submit" class="btn btn-primary my-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>