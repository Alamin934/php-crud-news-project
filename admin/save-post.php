<?php
    include 'config.php';
    session_start();
    if($_SESSION['user_role'] == false){
        header("Location: {$hostname}/admin/post.php");
    }
    if(isset($_FILES['fileToUpload'])){
        $error = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $exp = explode('.', $file_name);
        $file_ext = strtolower(end($exp));
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
// die();
    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $post_desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $post_cat = mysqli_real_escape_string($conn, $_POST['category']);
    $post_date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $add_sql = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES('{$post_title}','{$post_desc}',{$post_cat},'{$post_date}',{$author},'{$new_name}');";

    $add_sql.= "UPDATE category SET post = post + 1 WHERE category_id = {$post_cat}";

    if(mysqli_multi_query($conn, $add_sql)){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo "<div class='alert alert-danger'>Query Field.</div>";
    }


