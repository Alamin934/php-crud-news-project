<?php
    include 'config.php';
    session_start();

    if(isset($_SESSION['user_name'])){
        header("Location: {$hostname}/admin/post.php");
    }

?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>

                            <input type="submit" name="login" class="btn btn-primary" value="login" />

                        </form>
                        <!-- /Form  End -->
                        <?php
                            if(isset($_POST['login'])){
                                include 'config.php';
                                if(empty($_POST['username']) || empty($_POST['password'])){
                                    echo '<div class="alert alert-danger">All Fields must be entered</div>';
                                    die();
                                }else{
                                    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
                                    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

                                    $user_sql = "SELECT user_id, username, role FROM user WHERE username='{$user_name}' AND password = '{$password}'";
                                    $user_query = mysqli_query($conn, $user_sql) or die("Query unsuccessful");

                                    if(mysqli_num_rows($user_query)>0){
                                        while($user_info = mysqli_fetch_assoc($user_query)){
                                            session_start();
                                            $_SESSION['user_id'] = $user_info['user_id'];
                                            $_SESSION['user_name'] = $user_info['username'];
                                            $_SESSION['user_role'] = $user_info['role'];

                                            header("Location: {$hostname}/admin/post.php");
                                        }
                                    }else{
                                        echo "<div class='alert alert-danger'>Username and Password are not matched.</div>";
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
