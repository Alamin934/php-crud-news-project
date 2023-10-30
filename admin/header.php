<?php
    include 'config.php';
    session_start();

    if(!isset($_SESSION['user_name'])){
        header("Location: {$hostname}/admin/");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>ADMIN Panel</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <!-- HEADER -->
        <div id="header-admin">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-2">
                    <?php
                    $settings_sql = "SELECT * FROM settings";
                    $settings_query = mysqli_query($conn, $settings_sql) or die("Query unsuccessful");
            
                    if(mysqli_num_rows($settings_query)>0){
                        while($settings_info = mysqli_fetch_assoc($settings_query)){
                            if($settings_info['logo'] == ""){
                                echo '<a href="post.php"><h2 class="text-white">'.$settings_info['website_name'].'</h2>';
                            }else{
                                echo '<a href="post.php"><img class="logo" src="images/'.$settings_info['logo'].'"></a>';
                            }
                        }
                    }
                    ?>
                    </div>
                    <!-- /LOGO -->
                      <!-- LOGO-Out -->
                    <div class="col-md-offset-9  col-md-3">
                        <a href="" class="admin-logout"><?php echo $_SESSION['user_name'] ?>, </a>
                        <a href="logout.php" class="admin-logout" >logout</a>
                    </div>
                    <!-- /LOGO-Out -->
                </div>
            </div>
        </div>
        <!-- /HEADER -->
        <!-- Menu Bar -->
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a href="post.php">Post</a>
                            </li>
                        <?php
                            if($_SESSION['user_role'] == 1):
                        ?>
                            <li>
                                <a href="category.php">Category</a>
                            </li>
                            <li>
                                <a href="users.php">Users</a>
                            </li>
                            <li>
                                <a href="settings.php">Settings</a>
                            </li>
                        <?php
                            endif;
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Menu Bar -->
