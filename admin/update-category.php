<?php include "header.php";
if($_SESSION['user_role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['sumbit'])){
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);

    $update_sql = "UPDATE category SET category_name = '{$cat_name}' WHERE category_id = {$cat_id}";
    if(mysqli_query($conn, $update_sql)){
        header("Location: {$hostname}/admin/category.php");
    }else{
        die("Query unsuccessful");
    }
}


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php
                    $current_id = $_GET['id'];
                    $edit_sql = "SELECT * FROM category WHERE category_id = {$current_id}";
                    $edit_query = mysqli_query($conn, $edit_sql) or die("Query unsuccessful");

                    if(mysqli_num_rows($edit_query)>0):
                        while($edit_info = mysqli_fetch_assoc($edit_query)):
                ?>
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $edit_info['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $edit_info['category_name']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>
                <?php endwhile; endif; ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; mysqli_close($conn);?>
