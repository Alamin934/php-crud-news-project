<?php
    include 'admin/config.php';
    $settings_sql = "SELECT * FROM settings";
    $settings_query = mysqli_query($conn, $settings_sql) or die("Query unsuccessful");

    $setting_info = mysqli_fetch_assoc($settings_query);

    $page=basename($_SERVER['PHP_SELF']);

    switch($page){
        case "single.php":
            if(isset($_GET['id'])){
                $sql_title = "SELECT * FROM post WHERE post_id={$_GET['id']}";
                $result_title = mysqli_query($conn, $sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title['title'];
            }else{ $page_title= "Post not found";}
            break;
        case "category.php":
            if(isset($_GET['cid'])){
                $sql_title = "SELECT * FROM category WHERE category_id={$_GET['cid']}";
                $result_title = mysqli_query($conn, $sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title['category_name']." News";
            }else{ $page_title= "Category not found";}
            break;
        case "author.php":
            if(isset($_GET['aid'])){
                $sql_title = "SELECT * FROM user WHERE user_id={$_GET['aid']}";
                $result_title = mysqli_query($conn, $sql_title);
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = "Post by ".$row_title['first_name']." ".$row_title['last_name'];
            }else{ $page_title= "Username not found";}
            break;
        case "search.php":
            if(empty($_GET['search'])){
                $page_title= "Not Input any Word";
            }elseif(isset($_GET['search'])){
                $page_title = $_GET['search'];
            }
            else{ $page_title= "Search item not found";}
            break;
        default:
            $page_title = $setting_info['website_name'];
            break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="col-md-4">
            <?php   
                if($setting_info['logo'] == ""){
                    echo '<a href="index.php"><h2 class="text-white">'.$setting_info['website_name'].'</h2>';
                }else{
                    echo '<a href="index.php" class="text-center d-inline-block"><img class="logo" src="admin/images/'.$setting_info['logo'].'"></a>';
                } 
            ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'admin/config.php';
                if(isset($_GET['cid'])){
                    $current_id = $_GET['cid'];
                }
                $cat_sql = "SELECT * FROM category WHERE post>0";
                $cat_query = mysqli_query($conn, $cat_sql) or die("Query unsuccessful");

                if(mysqli_num_rows($cat_query)>0){
                    echo "<ul class='menu'>";
                    $active = "";
                        echo "<li><a href='{$hostname}'>Home</a></li>";
                    while($cat_info = mysqli_fetch_assoc($cat_query)){
                        if(isset($_GET['cid'])){
                            if($current_id == $cat_info['category_id']){
                                $active = "active";
                            }else{
                                $active = "";
                            }
                        }
                        echo "<li><a class='{$active}' href='category.php?cid={$cat_info['category_id']}'>{$cat_info['category_name']}</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
