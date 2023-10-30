<?php
include 'config.php';
session_start();
$post_id = $_GET['post_id'];
$cat_id = $_GET['cat_id'];

if(isset($_SESSION['user_role'])){
    $post_sql = "SELECT * FROM post WHERE post_id = {$post_id}";
    $post_query = mysqli_query($conn, $post_sql) or die("Query unsuccessful");
    
    $post_info = mysqli_fetch_assoc($post_query);
    unlink("upload/".$post_info['post_img']);
    
    
    $sql = "DELETE FROM post WHERE post_id = {$post_id};";
    $sql.= "UPDATE category SET post = post-1 WHERE category_id = {$cat_id}";
    
    if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo "Query Failed";
    }
}else{
    header("Location: {$hostname}/admin/index.php");
}