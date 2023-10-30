<?php
include 'config.php';
session_start();
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == '1'){
    $current_id = $_GET['id'];

    $del_sql = "DELETE FROM category WHERE category_id = {$current_id}";

    if(mysqli_query($conn, $del_sql)){
        header("Location: {$hostname}/admin/category.php");
    }else{
        echo "<p style='color:red; text-align:center; margin: 10px 0px;'>Can\'t Delete the Category.</p>";
    }
}else{
    header("Location: {$hostname}/admin/post.php");
}

mysqli_close($conn);