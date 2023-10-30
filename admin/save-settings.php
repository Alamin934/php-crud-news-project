<?php

include 'config.php';
if($_SESSION['user_role'] == false){
    header("Location: {$hostname}/admin/post.php");
}
if(empty($_FILES['logo']['name'])){
    $file_name = $_POST['old-logo'];
}else{
    $error = array();

    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['logo']['size'];
    $file_tmp = $_FILES['logo']['tmp_name'];
    $file_type = $_FILES['logo']['type'];
    $file_ext = strtolower(end(explode('.', $file_name)));
    $extensions = array("jpeg", "jpg", "png");

    if(in_array($file_ext, $extensions) === false){
        $error[] = "This extension file is not allowed, Please a JPG or PNG file";
    }
    if($file_size > 2097152){
        $error[] = "File size must be in 2mb or lower";
    }

    if(empty($error) == true){
        move_uploaded_file($file_tmp, "images/".$file_name);
    }else{
        print_r($error);
        die();
    }
}

$website_name = mysqli_real_escape_string($conn, $_POST['website_name']);
$footer_desc = mysqli_real_escape_string($conn, $_POST['footer_desc']);

$update_sql = "UPDATE settings SET website_name='{$website_name}', logo='{$file_name}', footer_desc='{$footer_desc}'";


if(mysqli_multi_query($conn, $update_sql)){
    header("Location: {$hostname}/admin/settings.php");
}else{
    echo "<div class='alert alert-danger'>Query Field.</div>";
}

