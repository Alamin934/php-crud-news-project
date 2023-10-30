<?php 
include "header.php";
include "config.php";
if($_SESSION['user_role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['submit'])){
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $update_query = "UPDATE user SET first_name='{$f_name}', last_name='{$l_name}', username='{$username}', role='{$role}' WHERE user_id = {$user_id}";
    if(mysqli_query($conn, $update_query)){
        header("Location: {$hostname}/admin/users.php");
    }
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
              <?php
                $current_id = $_GET['id'];

                $edit_user_sql = "SELECT * FROM user WHERE user_id={$current_id}";
                $edit_user_query = mysqli_query($conn, $edit_user_sql) or die("Query unsuccessful");

                if(mysqli_num_rows($edit_user_query)>0):
                    while($user = mysqli_fetch_assoc($edit_user_query)):
              ?>
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $user['user_id']; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $user['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $user['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" <?php $user['role']; ?>>
                          <?php 
                            if($user['role'] == 0){
                                echo "<option value='0' selected>Normal User</option>
                                      <option value='1'>Admin</option>";
                            }else{
                                echo "<option value='0'>Normal User</option>
                                      <option value='1' selected>Admin</option>";
                            }
                          ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
              <?php
                    endwhile;
                endif;
                mysqli_close($conn);
              ?>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
