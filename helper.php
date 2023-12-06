<?php
// require '../session.php';
include '../connect.php';
// include '../navbar/navbar.php';

function dd($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}

function queryGet($table,$sort = ''){
    
    $query = "SELECT n.*, u.name FROM ".$table." n JOIN users u ON u.id = n.created_by WHERE n.created_by = ? ";
    if($sort!= '' && $sort == 'asc'){
        $query .= "ORDER BY n.id ASC"; 
    }else if($sort == 'desc'){
        $query.= "ORDER BY n.id DESC";
    }
    
    return $query;
}

function query($table,$sort = '') {

     $query = "SELECT n.*, u.name 
          FROM " . $table . " n 
          JOIN users u ON u.id = n.created_by";
          if($sort!= '' && $sort == 'asc'){
            $query .= " ORDER BY n.id ASC"; 
        }else if($sort == 'desc'){
            $query.= " ORDER BY n.id DESC";
        }

    return $query;
}

function image($photo) {
    if (isset($_FILES[$photo]) && $_FILES[$photo]['name']) {
        $image = $_FILES[$photo];
        $imagefilename = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $filename_separated = explode('.', $imagefilename);
        $file_extension = strtolower($filename_separated[1]);
        $extension = array('jpg', 'jpeg', 'png');
        if (in_array($file_extension, $extension)) {
            $imagePath = '../image/' . $imagefilename;
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                return $imagePath;
            }
        }
    }
    return null;
}

?>