<?php
include 'config.php';
session_start();
if($_SESSION['user_role'] == false){
    header("Location: {$hostname}/admin/post.php");
}
if(empty($_FILES['new-image']['name'])){
    $new_name = $_POST['old-image'];
}else{
    $error = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
    $file_ext = strtolower(end(explode('.', $file_name)));
    $extensions = array("jpeg", "jpg", "png");

    if(in_array($file_ext, $extensions) === false){
        $error[] = "This extension file is not allowed, Please a JPG or PNG file";
    }
    if($file_size > 2097152){
        $error[] = "File size must be in 2mb or lower";
    }
    $new_name = basename($file_name,".".$file_ext)."-".date("j-m-Y-His").".".$file_ext;
    if(empty($error) == true){
        move_uploaded_file($file_tmp, "upload/".$new_name);
    }else{
        print_r($error);
        die();
    }
}

$post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$post_desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$post_cat = mysqli_real_escape_string($conn, $_POST['category']);
$post_old_cat = mysqli_real_escape_string($conn, $_POST['old_cat']);

// $post_sql = "SELECT * FROM post WHERE post_id = {$post_id}";
// $post_query = mysqli_query($conn, $post_sql);

// if(mysqli_num_rows($post_query)>0){
//     while($post_info = mysqli_fetch_assoc($post_query)){
//         $post_old_cat=$post_info['category'];
//         global $post_old_cat;
//     }
// }

$update_sql = "UPDATE post SET title='{$post_title}', description='{$post_desc}', category={$post_cat}, post_img='{$new_name}' WHERE post_id = {$post_id};";

$update_sql.= "UPDATE category SET post=post-1 WHERE category_id={$post_old_cat};";

$update_sql.= "UPDATE category SET post=post+1 WHERE category_id={$post_cat}";

if(mysqli_multi_query($conn, $update_sql)){
    header("Location: {$hostname}/admin/post.php");
}else{
    echo "<div class='alert alert-danger'>Query Field.</div>";
}

