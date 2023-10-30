<?php
include 'config.php';
session_start();
if($_SESSION['user_role'] == '1'){
    $current_id = $_GET['id'];
    $delete_sql = "DELETE FROM user WHERE user_id = {$current_id}";
    if(mysqli_query($conn, $delete_sql)){
        header("Location: {$hostname}/admin/users.php");
    }else{
        echo "<p style='color:red; text-align:center; margin: 10px 0px;'>Can\'t Delete the user.</p>";
    }
}else{
    header("Location: {$hostname}/admin/post.php");
}

mysqli_close($conn);

